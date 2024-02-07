#!/usr/bin/env bash

docker inspect --format='{{.NetworkSettings.Networks.gcpedia_default.IPAddress}}' gcpedia-gcpedia-1