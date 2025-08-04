php:=docker compose run --rm --remove-orphans app

composer-install:
	$(php) COMPOSER_MEMORY_LIMIT=2G COMPOSER_ALLOW_SUPERUSER=0 composer install

codecept-build: composer-install
	$(php) vendor/bin/codecept -c tests/codeception.yml build

codecept: codecept-build
	$(php) vendor/bin/codecept -c tests/codeception.yml run

sniffer-check:
	$(php) vendor/bin/phpcs -p

sniffer-fix:
	$(php) vendor/bin/phpcbf -p

cs-fixer-fix:
	$(php) vendor/bin/php-cs-fixer fix

cs-fixer-check:
	$(php) vendor/bin/php-cs-fixer check

rector-check:
	$(php) vendor/bin/rector --dry-run

rector-fix:
	$(php) vendor/bin/rector

phpstan:
	$(php) vendor/bin/phpstan analyze --no-progress -c phpstan.neon
