
# Haibun end to end tests

These BDD-style tests use [Haibun](https://github.com/withhaibun/haibun).

Setup:

`npm i`

## To run all tests:

`npm run test`

## To run individual tests

`npm run test -- <filter>`, for example, `npm run test -- create-account`

## Publish results

`npm run publish`


You can then use eg `npx live-server reviews` to make them available via a browser.

## Load tests

Load tests use the same comprehensive BDD tests via
[haibun-load-tests](https://github.com/withhaibun/haibun-load-tests). 
A dispatcher is used with clients; the clients can be run on distributed systems
via docker, to better partition resources.


## Run one load test

`npm run dispatcher`

`npm run local-client`

## Run 500 load tests

### On the dispatcher host:

`npm run dispatcher-500`

### On clients:

Copy the file env-client.simple to env-client and edit appropriately on each client host. 
For GCPedia, it would be easiest to point client DNS for "wiki.local" to the mediawiki instance, 
and change `HAIBUN_O_HAIBUNLOADTESTSSTEPPER_DISPATCHER_ADDRESS=http://<dispatcher-host>:8123` in the env file appropriately.

`docker-compose build`
`docker-compose up --scale clients=20 clients`

This will run 20 clients on each host.


Note that publishing load test results is a work in progress.