Handoff Plan for Next Agent

Objective
Implement a PHP CLI app that reads a 3-letter prefix and prints localized accommodation lines from MySQL, ordered by name.

Scope of work
1) Composer and autoload
   - composer.json with PSR-4 autoload: "App\\": "src/"
   - require-dev: phpunit/phpunit

2) Config
   - config/config.php returning array with DB DSN, user, pass, default_locale, result_limit

3) Domain
   - Create entities: `App\Domain\Accommodation` (abstract), `Hotel`, `Apartment`
   - Value objects: `Location`, enums `RoomType`, `AccommodationType`
   - Interface: `App\Domain\AccommodationRepository`

4) Application
   - Service: `App\Application\SearchAccommodationsService`
     - Dependencies: AccommodationRepository, Translator
     - Method: execute(string $prefix, string $locale): array

5) Infrastructure
   - Persistence: `App\Infrastructure\Persistence\PdoAccommodationRepository`
     - Uses PDO; prepared statements; LIKE :prefix% with proper collation
   - i18n: `App\Infrastructure\I18n\Translator` loading JSON catalogs from resources/i18n
   - CLI: `bin/search.php` reading STDIN, resolving locale (APP_LOCALE or config), wiring dependencies

6) Tests
   - Unit tests for domain and application service (mocks)
   - Integration tests for repository (requires test DB or dockerized MySQL)

7) Makefile (optional)
   - make test, make run PREFIX=Hot, make seed

Acceptance criteria
- Given a prefix of 3 characters, prints all matches sorted by name
- Output localized per locale; English default; Arabic and Chinese supported
- Handles Unicode names correctly from DB
- Uses OOP and clean layering; no frameworks

Implementation notes
- Use utf8mb4 and utf8mb4_unicode_ci in DSN: `charset=utf8mb4` and `SET NAMES utf8mb4`
- For sorting: rely on DB ORDER BY name; ensure connection collation matches schema
- Limit results via config (e.g., 200)
- Validation: if input < 3 chars, exit with message

Task breakdown
- [ ] Add composer.json and phpunit.xml
- [ ] Implement config/config.php
- [ ] Implement domain classes and enums
- [ ] Implement Translator and catalogs loader
- [ ] Implement PDO repository
- [ ] Implement SearchAccommodationsService
- [ ] Implement bin/search.php
- [ ] Write unit tests
- [ ] Write integration tests and fixtures
- [ ] Verify i18n outputs for en, es, ar, zh


