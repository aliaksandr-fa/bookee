#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

apt-get update -yqq
apt-get install git -yqq

curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
ls -la
composer install --no-scripts --optimize-autoloader --ignore-platform-reqs

