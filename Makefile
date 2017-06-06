.PHONY: test
test:
	@find tests/ -ipath '*/output/*.expected' -delete -or -ipath '*/output/*.actual' -delete
	@vendor/bin/tester tests/