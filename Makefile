up: docker-up

docker-restart: docker-down docker-up

docker-up:
	docker-compose up --build -d

docker-down:
	docker-compose down

frontend-install:
	docker-compose exec frontend-nodejs npm install

frontend-build:
	docker-compose exec frontend-nodejs npm run build

frontend-watch:
	docker-compose exec frontend-nodejs npm run watch

api-composer:
	docker-compose exec api-php-cli composer install

test:
	docker-compose exec api-php-cli composer test


migrations-generate:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:diff

migrations-migrate:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:migrate --no-interaction


fixtures:
	docker-compose run --rm api-php-cli php bin/console doctrine:fixtures:load --no-interaction
