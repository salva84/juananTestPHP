#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Application\SearchAccommodationsService;
use App\Infrastructure\I18n\Translator;
use App\Infrastructure\Persistence\PdoAccommodationRepository;
use PDO;

// Load configuration
$config = require __DIR__ . '/../config/config.php';

// Resolve locale from environment or config
$locale = $_ENV['APP_LOCALE'] ?? $config['default_locale'];

// Create PDO connection with UTF-8 support
$pdo = new PDO(
    $config['db']['dsn'],
    $config['db']['user'],
    $config['db']['password'],
    $config['db']['options']
);

// Set connection charset to ensure UTF-8
$pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

// Create dependencies
$repository = new PdoAccommodationRepository($pdo);
$translator = new Translator(__DIR__ . '/../resources/i18n');
$service = new SearchAccommodationsService($repository, $translator);

// Read input from STDIN
$input = trim(fgets(STDIN));
if (strlen($input) < 3) {
    fwrite(STDERR, "Error: Input must be at least 3 characters long\n");
    exit(1);
}

// Execute search
$results = $service->execute($input, $locale);

// Output results
foreach ($results as $result) {
    echo $result . "\n";
}


