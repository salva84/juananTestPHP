# PHP Accommodation Search - Makefile

.PHONY: help install test demo clean

help: ## Show this help message
	@echo "PHP Accommodation Search - Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2}'

install: ## Install dependencies (requires Composer)
	@echo "Installing dependencies..."
	composer install

test: ## Run unit tests
	@echo "Running unit tests..."
	php vendor/bin/phpunit

test-integration: ## Run integration tests (requires database)
	@echo "Running integration tests..."
	php vendor/bin/phpunit --group integration

demo: ## Run demonstration script
	@echo "Running application demo..."
	php demo.php

manual-test: ## Run manual domain test
	@echo "Running manual domain test..."
	php test_manual.php

run: ## Run CLI with sample input (requires database setup)
	@echo "Running CLI with sample input..."
	echo "Hot" | php bin/search.php

clean: ## Clean up generated files
	@echo "Cleaning up..."
	rm -rf vendor/
	rm -rf .phpunit.cache/

setup-db: ## Setup database (requires MySQL)
	@echo "Setting up database..."
	mysql -u root -p < db/schema.sql
	mysql -u root -p accommodations < db/seed.sql

# Default target
.DEFAULT_GOAL := help
