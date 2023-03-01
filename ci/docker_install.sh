#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

apt-get update -yqq
apt-get install git -yqq

curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader --ignore-platform-reqs
