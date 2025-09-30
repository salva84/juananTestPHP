PHP Accommodation Search (CLI)

Overview
This project is a small, high-quality PHP CLI application that reads the first three letters from standard input and prints all matching accommodations (Hotels and Apartments) from a MySQL database, ordered by name, including their characteristics and location.

It is designed with Object-Oriented Programming, clean architecture principles, and strong internationalization (i18n) support for Latin, Middle Eastern (RTL), and Asian languages.

Key capabilities
- Object-oriented design with clear domain boundaries
- Clean architecture layers (Domain, Application, Infrastructure)
- UTF-8 (utf8mb4) database schema and data
- i18n with JSON translation catalogs (en, es, ar, zh) and RTL awareness
- CLI first; LAMP-ready (Apache+PHP+MySQL) for portability
- PHPUnit testing setup (unit and integration)

Quick start
1) Prerequisites
   - PHP >= 8.1 with extensions: pdo_mysql, mbstring, intl
   - Composer
   - MySQL 8.x (or 5.7+) with UTF-8 (utf8mb4)

2) Install dependencies
   composer install

3) Create database and load sample data
   - Ensure MySQL is running.
   - Execute the DDL and seed files:
     mysql -u root -p < db/schema.sql
     mysql -u root -p accommodations < db/seed.sql

4) Configure application
   - Copy and edit config/config.php with your credentials and default locale.

5) Run the CLI
   - Example (type first three letters and press Enter):
     echo "Hot" | php bin/search.php

   Expected output format:
   Hotel Azul, 3 stars, double with view, Valencia, Valencia
   Apartamentos Beach, 10 apartments, 4 adults, Almeria, Almeria
   Hotel Blanco, 4 stars, double, Mojacar, Almeria
   ...

Project structure
- bin/                CLI entry points
- config/             Configuration files (DB credentials, default locale)
- db/                 SQL DDL and seed data
- docs/               Documentation and UML diagrams
- resources/i18n/     JSON translation catalogs (en, es, ar, zh)
- src/                Application source code (Domain, Application, Infrastructure)
- tests/              PHPUnit tests

Architecture (short)
Please see docs/ARCHITECTURE.md for a full description. In short:
- Domain: entities, value objects, repository interfaces
- Application: use cases (e.g., SearchAccommodationsService)
- Infrastructure: PDO repository, i18n translator, CLI IO

Internationalization (short)
See docs/I18N.md for details. The output is localized using JSON catalogs. RTL languages (e.g., Arabic) are supported.

Deployment to LAMP
Instructions in docs/DEPLOYMENT.md. The app runs on PHP CLI and connects to MySQL. Apache is optional if you later add an HTTP interface.

Testing
See docs/TESTING.md. PHPUnit is configured via phpunit.xml. Run:
composer test

License
Use and adapt freely for the technical exercise.


