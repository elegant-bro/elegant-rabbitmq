php:=docker compose run --rm --remove-orphans app

composer-install:
	$(php) composer install

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

tests: composer-install
	$(php) vendor/bin/phpunit
