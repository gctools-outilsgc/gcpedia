targetScope = 'resourceGroup'

param location string = 'Canada Central'

@description('either both planID and subnetID are set or both are empty')
param planID string
@description('either both planID and subnetID are set or both are empty')
param subnetID string

param dbServerRG string
param dbServerName string
param dbServerPass string

param prName string = 'latest'
param containerTag string = 'latest'
param containerSHA string = ''

param acrName string = 'wikitestacr'

@allowed([
  '', 'php|8.2'
])
param phpEnv string = ''
param appCommandLine string = ''
param scriptPath string = ''
param articlePath string = ''

param cacheType string = ''

@allowed([
  'gcpedia', 'gcwiki'
])
param siteType string = 'gcwiki'

var DATAROOT = '/var/www/html/images/'

var imageRepoName = toLower('wiki_${prName}')
var containerImage = empty(containerSHA) ? 'DOCKER|${acrName}.azurecr.io/${imageRepoName}:${containerTag}' : 'DOCKER|${acrName}.azurecr.io/${imageRepoName}@sha256:${containerSHA}'
var linuxFxVersion = empty(phpEnv) ? containerImage : phpEnv

var appName = '${siteType}-dev-${prName}'
var dbName = '${siteType}-${prName}'
var nodash_nounderscore_tag = replace(replace(prName, '-', ''), '_', '')
var storagePrefix = toLower( (length(nodash_nounderscore_tag)) > 17 ? substring('devgcwiki${nodash_nounderscore_tag}', 0, 24) : 'devgcwiki${nodash_nounderscore_tag}' )


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
      appCommandLine: appCommandLine
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
          value: 'true'
        }
        {
          name: 'SITE'
          value: siteType
        }
        {
          name: 'DBTYPE'
          value: 'mysql' 
        }
        {
          name: 'DBHOST'
          value: '${dbServerName}.mysql.database.azure.com' 
        }
        {
          name: 'DBUSER'
          value: 'wiki' 
        }
        {
          name: 'DBPASS'
          value: dbServerPass
        }
        {
          name: 'DBNAME'
          value: dbName
        }
        {
          name: 'DBSSL'
          value: '0'
        }
        {
          name: 'WIKI_PROTOCOL'
          value: 'https'
        }
        {
          name: 'WIKI_HOST'
          value: '${appName}.azurewebsites.net'
        }
        {
          name: 'WIKI_PORT'
          value: ''
        }
        {
          name: 'SCRIPT_PATH'
          value: scriptPath
        }
        {
          name: 'ARTICLE_PATH'
          value: articlePath
        }
        {
          name: 'CACHE_TYPE'
          value: cacheType
        }
        {
          name: 'WIKI_DEBUG'
          value: 'true'
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
    dbName: dbName
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
  name: 'w-test-files'
  properties: {
    accessTier: 'TransactionOptimized'
    shareQuota: 5120
  }
}
