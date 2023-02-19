up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down docker-pull docker-build docker-up bookee-init bookee-about

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-down-clear:
	 docker-compose down -v --remove-orphans

docker-build:
	docker-compose build

docker-pull:
	docker-compose pull

bookee-clear-cache:
	docker-compose run --rm bookee-php-cli  bin/console cache:clear

bookee-init: composer-install bookee-migrations bookee-fixtures

bookee-migrations:
	docker-compose run --rm bookee-php-cli bin/console doctrine:migrations:migrate --no-interaction

bookee-fixtures:
	docker-compose run --rm bookee-php-cli  bin/console doctrine:fixtures:load --no-interaction

bookee-about:
	docker-compose run --rm bookee-php-cli  bin/console bookee:about

composer-install:
	docker-compose run --rm bookee-php-cli composer install

#schema-create:
#	docker-compose run --rm bookee-php-cli  bin/console doctrine:schema:create
#
#schema-drop:
#	docker-compose run --rm bookee-php-cli  bin/console doctrine:schema:drop --force --full-database

mapping-info:
	docker-compose run --rm bookee-php-cli  bin/console doctrine:mapping:info

test:
	docker-compose run --rm bookee-php-cli php ./vendor/bin/phpunit
	#docker-compose run --rm bookee-php-cli php ./vendor/bin/phpunit --coverage-text
	#docker-compose run --rm bookee-php-cli php ./vendor/bin/phpunit --coverage-html=coverage

test-unit:
	docker-compose run --rm bookee-php-cli php ./vendor/bin/phpunit --testsuite=unit

test-functional:
	docker-compose run --rm bookee-php-cli php ./vendor/bin/phpunit --testsuite=functional

consume:
	docker-compose run --rm bookee-php-cli php bin/console messenger:consume

show-commands:
	docker-compose run --rm bookee-php-cli  bin/console | grep bookee

php-stan:
	docker-compose run --rm bookee-php-cli ./vendor/bin/phpstan analyse src tests