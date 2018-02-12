[![Build Status](https://travis-ci.org/gctools-outilsgc/gcpedia.svg?branch=master)](https://travis-ci.org/gctools-outilsgc/gcpedia)

# GCpedia

Master branch: work in progress, mostly working upgraded to mediawiki 1.29

GCpedia branch: almost identical to current GCpedia production

Both branches include Dockerfiles to build docker images as well as docker compose files for both docker-compose and docker stack/swarm
A docker-compose file for setting up a jenkins + docker worker environment is also available.

The main Dockerfile is alpine linux-based, an ubuntu-based one is also available.

## Dev install
Easy way: 
clone the repo, 
run
```
docker-compose up
```
add an entry into your hosts file for
```
<host ip> wiki.gccollab.dev
```

and you now have a fully installed instance of the wiki (visual editor service extra, needs at bit more work) that you can reach at wiki.gccollab.dev! This setup will also allow it to reflect any changes that are made to the code you just pulled without needing to do anything.
