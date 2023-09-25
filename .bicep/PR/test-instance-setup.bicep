targetScope = 'subscription'

param prNumber string = 'latest'
param containerTag string = 'latest'
param dbServerRG string
param dbServerName string
param dbServerPass string
param subnetID string
param planID string
param acrName string = 'wikitestacr'

param location string = 'Canada Central'

resource testRG 'Microsoft.Resources/resourceGroups@2021-01-01' = {
  name: 'wiki_review_${prNumber}'
  location: location
}

module wiki './wiki-test-instance.bicep' = {
  name: 'wiki-test-infra'
  scope: resourceGroup(testRG.name)
  params: {
    containerTag: containerTag
    prNumber: 'PR-${prNumber}'
    subnetID: subnetID
    planID: planID
    dbServerRG: dbServerRG
    dbServerName: dbServerName
    dbServerPass: dbServerPass
    acrName: acrName
  }
}
