#!/bin/bash

docker-compose --env-file=../.env -f deploy/docker-compose.yml down
