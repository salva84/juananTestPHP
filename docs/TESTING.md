Testing Strategy

Scope
- Unit tests for domain entities and value objects
- Application service tests (SearchAccommodationsService) with mocked repository and translator
- Integration tests for PdoAccommodationRepository against a test database

Tools
- PHPUnit (configured via phpunit.xml)

Running tests
- composer test

Data strategy
- Use dedicated test database/schema or transactional tests
- Seed minimal fixtures for integration tests

Notes
- Mark long-running integration tests with @group integration and exclude by default if needed


