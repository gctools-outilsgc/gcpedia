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
    virtualNetworkSubnetId: subnet.id
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
          value: '${dbserver.properties.fullyQualifiedDomainName}'
        }
        {
          name: 'DBUSER'
          value: 'wiki' 
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
          name: 'WIKI_HOST'
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



/*
**** DB + config ****
*/
resource dbserver 'Microsoft.DBforMySQL/flexibleServers@2023-06-30' = {
  location: location
  name: dbName
  sku: {
    name: 'Standard_B1ms'
    tier: 'Burstable'
  }
  properties: {
    createMode: 'Default'
    version: '8.0.21'
    administratorLogin: 'wiki'
    administratorLoginPassword: dbpassword
    storage: {
      storageSizeGB: 20
      autoGrow: 'Enabled'
    }
  }
}

resource database 'Microsoft.DBforMySQL/flexibleServers/databases@2023-06-30' = {
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

resource subnet 'Microsoft.Network/virtualNetworks/subnets@2021-08-01' = if (empty(subnetID)) {
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


resource subnetDB 'Microsoft.Network/virtualNetworks/subnets@2021-08-01' = if (empty(subnetID)) {
  name: 'devdb'
  parent: vnet
  properties: {
    addressPrefix: '10.0.1.0/24'
    serviceEndpoints: endpoints
    delegations: []
    privateEndpointNetworkPolicies: 'Enabled'
    privateLinkServiceNetworkPolicies: 'Enabled'
  }
  dependsOn: [
    vnet
  ]
}

/*
** private endpoint stuff
*/

resource privateDnsZones_privatelink_mysql 'Microsoft.Network/privateDnsZones@2018-09-01' = if (empty(subnetID)) {
  name: 'privatelink.mysql.database.azure.com'
  location: 'global'
}

resource privateDnsZones_privatelink_mysql_record 'Microsoft.Network/privateDnsZones/A@2018-09-01' = if (empty(subnetID)) {
  parent: privateDnsZones_privatelink_mysql
  name: dbName
  properties: {
    ttl: 10
    aRecords: [
      {
        ipv4Address: '10.0.1.4'
      }
    ]
  }
}

resource privateDnsZones_CNAME_privatelink_mysql 'Microsoft.Network/privateDnsZones/CNAME@2018-09-01' = if (empty(subnetID)) {
  parent: privateDnsZones_privatelink_mysql
  name: 'wiki-dev'
  properties: {
    ttl: 3600
    cnameRecord: {
      cname: '${dbName}.privatelink.mysql.database.azure.com'
    }
  }
}

resource vnetLink 'Microsoft.Network/privateDnsZones/virtualNetworkLinks@2020-06-01' = if (empty(subnetID)) {
  name: uniqueString(vnet.id)
  location: 'global'
  parent: privateDnsZones_privatelink_mysql
  properties: {
    registrationEnabled: false
    virtualNetwork: {
      id: vnet.id
    }
  }
}

resource dbPrivateEndpoint 'Microsoft.Network/privateEndpoints@2023-04-01' = if (empty(subnetID)) {
  name: 'wiki-endpoint'
  location: location
  properties: {
    privateLinkServiceConnections: [
      {
        name: 'wiki-endpoint'
        properties: {
          privateLinkServiceId: dbserver.id
          groupIds: [
            'mysqlServer'
          ]
        }
      }
    ]
    subnet: {
      id: subnetDB.id
    }

  }
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
