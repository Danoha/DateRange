.PHONY: test
test:
	@find tests/ -ipath '*/output/*.expected' -delete -or -ipath '*/output/*.actual' -delete
	@vendor/bin/tester -c tests/php.ini --coverage tests/coverage.html --coverage-src src/ tests/