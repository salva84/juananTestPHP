Deployment (LAMP + CLI)

Environment
- Linux/Apache/MySQL/PHP (LAMP) stack; Apache optional for CLI-only usage
- PHP >= 8.1 with pdo_mysql, mbstring, intl

Database
1) Create schema and tables
   mysql -u root -p < db/schema.sql

2) Seed sample data
   mysql -u root -p accommodations < db/seed.sql

Character set
- Ensure server and connection use utf8mb4 and utf8mb4_unicode_ci collation

Configuration
- Copy config/config.php and set DSN, user, password, default_locale

Run CLI
- echo "Hot" | php bin/search.php

Security
- Keep real credentials out of VCS; use environment-specific config files or environment variables

Extensions
- intl for i18n; mbstring for Unicode; pdo_mysql for DB access


