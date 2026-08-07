#!/usr/bin/env bash
set -ex

wait_for_docker() {
  while true; do
    docker ps > /dev/null 2>&1 && break
    sleep 1
  done
  echo "Docker is ready."
}

wait_for_docker

# download images beforehand, optional
ddev utility download-images

# avoid errors on rebuilds
ddev poweroff

# start ddev project automatically
ddev start -y

# further automated install / setup steps, e.g.
ddev composer install
