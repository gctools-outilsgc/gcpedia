# GCpedia

Main branch: Dockerfile and customizations off mediawiki 1.40 for GCwiki and GCpedia.

GCpedia branch: current GCpedia production, more of an archive at this point.

Both branches include Dockerfiles to build docker images as well as docker compose files for a dev environment using docker compose.

The main Dockerfile is based off docker hub's official Mediawiki image.

## Dev install
Easy way: 
clone the repo, 
inside the cloned repo directory run
```
docker-compose up
```
add an entry into your hosts file for
```
<host ip> wiki.local
```

and you now have a fully installed instance of the wiki (visual editor service extra, needs at bit more work for the older gcpedia version) that you can reach at wiki.local! 

By default the only directories mapped into the running dev instance container are ./images to persist any files you upload and ./data to persist the database, when working on an extension that lives in the repo it can similarly be mapped to reflect code changes without needing to rebuild the container image every time.

## e2e reviews

Available [here](https://gctools-outilsgc.github.io/gcpedia/haibun/reviews/dashboard.html).


