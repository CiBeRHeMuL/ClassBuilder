PHP = php
PWD := $(shell pwd)

test:
	$(PHP) $(PWD)/vendor/bin/phpunit -c $(PWD)/phpunit.xml.dist --bootstrap $(PWD)/tests/bootstrap.php --coverage-text --coverage-html $(PWD)/.phpunit.coverage tests

test-clover:
	$(PHP) $(PWD)/vendor/bin/phpunit -c $(PWD)/phpunit.xml.dist --bootstrap $(PWD)/tests/bootstrap.php --coverage-clover $(PWD)/coverage.xml tests

cs-fix:
	$(PHP) $(PWD)/vendor/bin/php-cs-fixer fix --config "$(PWD)/.php-cs-fixer.dist.php"

cs-check:
	$(PHP) $(PWD)/vendor/bin/php-cs-fixer check --config "$(PWD)/.php-cs-fixer.dist.php" --verbose --diff
