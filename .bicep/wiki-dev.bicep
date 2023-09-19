targetScope = 'resourceGroup'

/*
* can be used in a script to deploy a wiki instance using only azure managed services
*/
param location string = 'Canada Central'

@description('either both planID and subnetID are set or both are empty')
param planID string = ''
@description('either both planID and subnetID are set or both are empty')
param subnetID string = ''

param containerTag string = 'latest'
param containerSHA string = ''

param dbpassword string = 'Testing123-DS12*E'

var endpoints = [
  {
    service: 'Microsoft.KeyVault'
    locations: [
      '*'
    ]
  }
  {
    service: 'Microsoft.Storage'
    locations: [
      'canadacentral'
      'canadaeast'
    ]
  }
  {
    service: 'Microsoft.Web'
    locations: [
      '*'
    ]
  }
  {
    service: 'Microsoft.Sql'
    locations: [
      '*'
    ]
  }
]

var linuxFxVersion = empty(containerSHA) ? 'DOCKER|phanoix/gcpedia:${containerTag}' : 'DOCKER|phanoix/gcpedia@sha256:${containerSHA}'

var appName = 'wiki-dev-${containerTag}'
var dbName = 'wiki-dev-db-${containerTag}'
var storagePrefix  = length(containerTag) > 17 ? substring('devwiki${replace(replace(containerTag, '-', ''), '_', '')}', 0, 24) : 'devwiki${replace(replace(containerTag, '-', ''), '_', '')}'


/*
**** Web app + config ****
*/
resource webApp 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  kind: 'app,linux,container'
  properties: {
    serverFarmId: empty(planID) ? servicePlan.id : planID
    siteConfig: {
      linuxFxVersion: linuxFxVersion
      appSettings: [
        {
          name: 'WEBSITES_ENABLE_APP_SERVICE_STORAGE'
          value: 'false'
        }
        {
          name: 'DOCKER_REGISTRY_SERVER_URL'
          value: 'https://index.docker.io'
        }
        {
          name: 'DOCKER'
          value: '1'
        }
        {
          name: 'INIT'
          value: 'wiki'
        }
        {
          name: 'DBHOST'
          value: '${dbserver.name}.mariadb.database.azure.com' 
        }
        {
          name: 'DBUSER'
          value: 'wiki@${dbserver.name}' 
        }
        {
          name: 'DBPASS'
          value: dbpassword
        }
        {
          name: 'DBNAME'
          value: 'wiki_test'
        }
        {
          name: 'HOST'
          value: '${appName}.azurewebsites.net'
        }
      ]

      azureStorageAccounts: {
        collabtestdata: {
          type: 'AzureFiles'
          accountName: storagePrefix
          accessKey: listKeys(storageAccount.id, '2022-05-01').keys[0].value
          shareName: 'w-test-files'
          mountPath: '/var/www/html/images/'
        }
      }
    }
  }
}


// vnet connection
resource app_vnet 'Microsoft.Web/sites/networkConfig@2020-06-01' = {
  name: 'virtualNetwork'
  parent: webApp
  properties: {
    subnetResourceId: !empty(subnetID) ? subnetID : subnet.id
  }
}



/*
**** DB + config ****
*/
resource dbserver 'Microsoft.DBforMariaDB/servers@2018-06-01' = {
  location: location
  name: dbName
  sku: {
    name: 'GP_Gen5_2'
    tier: 'GeneralPurpose'
    capacity: 2
    size: string(5120)
    family: 'Gen5'
  }
  properties: {
    createMode: 'Default'
    version: '10.3'
    administratorLogin: 'wiki'
    administratorLoginPassword: dbpassword
    storageProfile: {
      storageMB: 5120
      storageAutogrow: 'Enabled'
      backupRetentionDays: 7
      geoRedundantBackup: 'Disabled'
    }
    sslEnforcement: 'Disabled'
  }
}

resource AllowSubnet 'Microsoft.DBforMariaDB/servers/virtualNetworkRules@2018-06-01' = {
  parent: dbserver
  name: 'AllowSubnet'
  properties: {
    virtualNetworkSubnetId: !empty(subnetID) ? subnetID : subnet.id
    ignoreMissingVnetServiceEndpoint: false
  }
}

resource database 'Microsoft.DBforMariaDB/servers/databases@2018-06-01' = {
  parent: dbserver
  name: 'wiki_test'
  properties: {
    charset: 'utf8'
    collation: 'utf8_general_ci'
  }
}



/*
**** files + config ****
*/
resource storageAccount 'Microsoft.Storage/storageAccounts@2022-05-01' = {
    name: storagePrefix
    location: location
    kind: 'StorageV2'

    sku: {
        name: 'Standard_LRS'
    }
    properties: {
        minimumTlsVersion: 'TLS1_2'
        accessTier: 'Hot'

        networkAcls: {
            bypass: 'None'
            defaultAction: 'Deny'
            virtualNetworkRules: empty(empty(subnetID) ? subnet.id : subnetID) ? [] : [
                {
                    id: empty(subnetID) ? subnet.id : subnetID
                    action: 'Allow'
                }
            ]
        }
    }
}

resource storageAccountFiles 'Microsoft.Storage/storageAccounts/fileServices@2022-05-01' = {
  parent: storageAccount
  name: 'default'
  sku: {
    name: 'Standard_LRS'
    tier: 'Standard'
  }
  properties: {
    shareDeleteRetentionPolicy: {
      enabled: false
    }
  }
}

resource file_share 'Microsoft.Storage/storageAccounts/fileServices/shares@2022-05-01' = {
  parent: storageAccountFiles
  name: 'w-test-files'
  properties: {
    accessTier: 'TransactionOptimized'
    shareQuota: 5120
  }
}

/**
*   pdf service
*/
resource webAppPDF 'Microsoft.Web/sites@2022-03-01' = {
  name: '${appName}pdf'
  location: location
  kind: 'app,linux,container'
  properties: {
    serverFarmId: empty(planID) ? servicePlan.id : planID
    siteConfig: {
      linuxFxVersion: 'DOCKER|msokk/electron-render-service:1.0.0'
      appSettings: [
        {
          name: 'WEBSITES_ENABLE_APP_SERVICE_STORAGE'
          value: 'false'
        }
        {
          name: 'DOCKER_REGISTRY_SERVER_URL'
          value: 'https://index.docker.io'
        }
        {
          name: 'RENDERER_ACCESS_KEY'
          value: 'supersecret!'
        }
        {
          name: 'WINDOW_WIDTH'
          value: '1024' 
        }
        {
          name: 'WINDOW_HEIGHT'
          value: '768' 
        }
        {
          name: 'PORT'
          value: '3000'
        }
        {
          name: 'TIMEOUT'
          value: '30'
        }
        {
          name: 'CONCURRENCY'
          value: '1'
        }
      ]
    }
  }
}


/*
**** Vnet + subnet ****
*/
resource vnet 'Microsoft.Network/virtualNetworks@2021-08-01' = if (empty(subnetID)) {
  name: 'collab_test_vnet'
  location: location
  properties: {
    addressSpace: {
      addressPrefixes: ['10.0.0.0/16']
    }
    enableDdosProtection: false
  }
}

resource subnet 'Microsoft.Network/virtualNetworks/subnets@2021-08-01' = {
  name: 'dev'
  parent: vnet
  properties: {
    addressPrefix: '10.0.0.0/24'
    serviceEndpoints: endpoints
    delegations: [
      {
        name: 'delegation'
        id: '${vnet.id}/delegations/delegation'
        properties: {
          serviceName: 'Microsoft.Web/serverfarms'
        }
        type: 'Microsoft.Network/virtualNetworks/subnets/delegations'
      }
    ]
    privateEndpointNetworkPolicies: 'Enabled'
    privateLinkServiceNetworkPolicies: 'Enabled'
  }
  dependsOn: [
    vnet
  ]
}

/*
**** app plan - if not provided ****
*/
resource servicePlan 'Microsoft.Web/serverfarms@2021-02-01' = if (empty(planID)) {
  name: appName
  location: location
  kind: 'linux'
  sku: {
    name: 'P1v2'
    tier: 'PremiumV2'
    size: 'P1v2'
  }
  properties: {
    reserved: true
  }
}
