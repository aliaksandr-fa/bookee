#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
apt-get install git -yqq

# Install phpunit, the tool that we will use for testing
curl --location --output /usr/local/bin/phpunit "https://phar.phpunit.de/phpunit.phar"
chmod +x /usr/local/bin/phpunit

curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet
composer install --no-dev --no-scripts --prefer-dist --optimize-autoloader

# Install mysql driver
# Here you can install any other extension that you need
#docker-php-ext-install pdo_mysql