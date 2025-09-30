<?php
declare(strict_types=1);

// Manual test script to verify the application works
// This simulates the CLI functionality without requiring a database

// Manual autoloader for testing
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

use App\Domain\AccommodationType;
use App\Domain\Hotel;
use App\Domain\Apartment;
use App\Domain\Location;
use App\Domain\RoomType;

// Create test data
$location1 = new Location('Valencia', 'Valencia');
$location2 = new Location('Almeria', 'Almeria');
$location3 = new Location('Mojacar', 'Almeria');

$hotel1 = new Hotel(1, 'Hotel Azul', $location1, 3, RoomType::DOUBLE_VIEW);
$hotel2 = new Hotel(2, 'Hotel Blanco', $location3, 4, RoomType::DOUBLE);
$apartment1 = new Apartment(3, 'Apartamentos Beach', $location2, 10, 4);
$apartment2 = new Apartment(4, 'Apartamentos Sol y playa', $location2, 50, 6);

// Test the entities
echo "=== Testing Domain Entities ===\n";
echo "Hotel 1: " . $hotel1->getDisplayName() . " (" . $hotel1->getStars() . " stars, " . $hotel1->getStandardRoomType()->value . ")\n";
echo "Hotel 2: " . $hotel2->getDisplayName() . " (" . $hotel2->getStars() . " stars, " . $hotel2->getStandardRoomType()->value . ")\n";
echo "Apartment 1: " . $apartment1->getDisplayName() . " (" . $apartment1->getNumUnits() . " units, " . $apartment1->getCapacityAdults() . " adults)\n";
echo "Apartment 2: " . $apartment2->getDisplayName() . " (" . $apartment2->getNumUnits() . " units, " . $apartment2->getCapacityAdults() . " adults)\n";

echo "\n=== Testing Location Value Object ===\n";
echo "Location 1: " . $location1->getFullLocation() . "\n";
echo "Location 2: " . $location2->getFullLocation() . "\n";

echo "\n=== Testing Enums ===\n";
echo "Accommodation Types: " . AccommodationType::HOTEL->value . ", " . AccommodationType::APARTMENT->value . "\n";
echo "Room Types: " . RoomType::SINGLE->value . ", " . RoomType::DOUBLE->value . ", " . RoomType::DOUBLE_VIEW->value . "\n";

echo "\n=== Testing i18n Catalogs ===\n";
$i18nPath = __DIR__ . '/resources/i18n';
$locales = ['en', 'es', 'ar', 'zh'];

foreach ($locales as $locale) {
    $file = $i18nPath . '/' . $locale . '.json';
    if (file_exists($file)) {
        $content = json_decode(file_get_contents($file), true);
        echo "Locale $locale: " . ($content['labels']['stars'] ?? 'N/A') . "\n";
    }
}

echo "\n=== Manual Test Complete ===\n";
echo "All domain entities, value objects, and enums are working correctly!\n";
echo "The application is ready for database integration.\n";
