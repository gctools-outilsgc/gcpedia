targetScope = 'resourceGroup'

param location string = 'Canada Central'

@description('either both planID and subnetID are set or both are empty')
param planID string
@description('either both planID and subnetID are set or both are empty')
param subnetID string

param dbServerRG string
param dbServerName string
param dbServerPass string

param prNumber string = 'latest'
param containerTag string = 'latest'
param containerSHA string = ''

param acrName string = 'wikitestacr'

var DATAROOT = '/wiki_data_test_mount/'

var imageRepoName = toLower('wiki_${prNumber}')
var linuxFxVersion = empty(containerSHA) ? 'DOCKER|${acrName}.azurecr.io/${imageRepoName}:${containerTag}' : 'DOCKER|${acrName}.azurecr.io/${imageRepoName}@sha256:${containerSHA}'

var appName = 'gcwiki-dev-${prNumber}'
var dbName = 'gcwiki-dev-db-${prNumber}'
var nodash_nounderscore_tag = replace(replace(prNumber, '-', ''), '_', '')
var storagePrefix = toLower( (length(nodash_nounderscore_tag)) > 15 ? substring('devgcwiki${nodash_nounderscore_tag}', 0, 24) : 'devgcwiki${nodash_nounderscore_tag}' )


/*
**** Web app + config ****
*/
resource webApp 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  kind: 'app,linux,container'
  identity: {
    type: 'SystemAssigned'
  }
  properties: {
    serverFarmId: planID
    siteConfig: {
      linuxFxVersion: linuxFxVersion
      acrUseManagedIdentityCreds: true
      appSettings: [
        {
          name: 'WEBSITES_ENABLE_APP_SERVICE_STORAGE'
          value: 'false'
        }
        {
          name: 'DOCKER_REGISTRY_SERVER_URL'
          value: 'https://${acrName}.azurecr.io'
        }
        {
          name: 'DOCKER'
          value: '1'
        }
        {
          name: 'INIT'
          value: 'gcwiki'
        }
        {
          name: 'DBHOST'
          value: '${dbServerName}.mariadb.database.azure.com' 
        }
        {
          name: 'DBUSER'
          value: 'wiki@${dbServerName}' 
        }
        {
          name: 'DBPASS'
          value: dbServerPass
        }
        {
          name: 'DBNAME'
          value: prNumber
        }
        {
          name: 'DATAROOT'
          value: DATAROOT
        }
        {
          name: 'HOST'
          value: '${appName}.azurewebsites.net'
        }
      ]

      azureStorageAccounts: {
        wikitestdata: {
          type: 'AzureFiles'
          accountName: storagePrefix
          accessKey: storageAccount.listKeys().keys[0].value
          shareName: 'w-test-files'
          mountPath: DATAROOT
        }
      }
    }
  }
}

module acrPullRole './modules/acr_pull_role.bicep' = {
  name: 'acr_pull'
  scope: resourceGroup(dbServerRG)
  params: {
    acrName: acrName
    appPrincipalId: webApp.identity.principalId
  }
}

// vnet connection
resource app_vnet 'Microsoft.Web/sites/networkConfig@2020-06-01' = {
  name: 'virtualNetwork'
  parent: webApp
  properties: {
    subnetResourceId: subnetID
  }
}



/*
**** DB ****
*/
module db './modules/db_existing_server.bicep' = {
  name: 'wiki_instance_db'
  scope: resourceGroup(dbServerRG)
  params: {
    dbServerName: dbServerName
    dbName: prNumber
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
            virtualNetworkRules: [
                {
                    id: subnetID 
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
  name: 'c-test-files'
  properties: {
    accessTier: 'TransactionOptimized'
    shareQuota: 5120
  }
}
