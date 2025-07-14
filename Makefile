install:
	composer install

lint:
	composer exec --verbose phpcs -- src tests

test:
	composer exec --verbose phpunit tests