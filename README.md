[![Build Status](https://travis-ci.org/gctools-outilsgc/gcpedia.svg?branch=master)](https://travis-ci.org/gctools-outilsgc/gcpedia)

# GCpedia

Master branch: Dockerfile and customizations off mediawiki 1.30 for GCwiki.

GCpedia branch: current GCpedia production

Both branches include Dockerfiles to build docker images as well as docker compose files for both docker-compose and docker stack/swarm

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
<host ip> wiki.local
```

and you now have a fully installed instance of the wiki (visual editor service extra, needs at bit more work) that you can reach at wiki.local! 

This setup will also reflect any changes that you make to the code you just pulled without needing to do anything extra.

## e2e reviews

Available [here](https://gctools-outilsgc.github.io/gcpedia/haibun/reviews/dashboard.html).


