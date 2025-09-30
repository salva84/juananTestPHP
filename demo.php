<?php
declare(strict_types=1);

// Demo script showing the complete application functionality
// This simulates the CLI behavior with mock data

// Manual autoloader
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

// Mock repository for demo
class MockAccommodationRepository implements \App\Domain\AccommodationRepository
{
    public function searchByNamePrefix(string $prefix, int $limit = 200): array
    {
        $accommodations = [
            new Hotel(1, 'Hotel Azul', new Location('Valencia', 'Valencia'), 3, RoomType::DOUBLE_VIEW),
            new Hotel(2, 'Hotel Blanco', new Location('Mojacar', 'Almeria'), 4, RoomType::DOUBLE),
            new Hotel(3, 'Hotel Rojo', new Location('Sanlucar', 'Cádiz'), 3, RoomType::SINGLE),
            new Apartment(4, 'Apartamentos Beach', new Location('Almeria', 'Almeria'), 10, 4),
            new Apartment(5, 'Apartamentos Sol y playa', new Location('Málaga', 'Málaga'), 50, 6),
        ];
        
        return array_filter($accommodations, function($acc) use ($prefix) {
            return stripos($acc->getName(), $prefix) === 0;
        });
    }
}

// Mock translator for demo
class MockTranslator implements \App\Infrastructure\I18n\TranslatorInterface
{
    private array $catalogs = [
        'en' => [
            'labels' => ['stars' => 'stars', 'apartments' => 'apartments', 'adults' => 'adults', 'standard_room' => 'standard room'],
            'roomTypes' => ['single' => 'single', 'double' => 'double', 'double_view' => 'double with view', 'suite' => 'suite', 'family' => 'family']
        ],
        'es' => [
            'labels' => ['stars' => 'estrellas', 'apartments' => 'apartamentos', 'adults' => 'adultos', 'standard_room' => 'habitación estándar'],
            'roomTypes' => ['single' => 'sencilla', 'double' => 'doble', 'double_view' => 'doble con vistas', 'suite' => 'suite', 'family' => 'familiar']
        ]
    ];
    
    public function translate(string $key, string $locale): string
    {
        $catalog = $this->catalogs[$locale] ?? $this->catalogs['en'];
        $keys = explode('.', $key);
        $value = $catalog;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) return $key;
            $value = $value[$k];
        }
        
        return is_string($value) ? $value : $key;
    }
}

// Demo the application
echo "=== PHP Accommodation Search Demo ===\n\n";

$repository = new MockAccommodationRepository();
$translator = new MockTranslator();
$service = new \App\Application\SearchAccommodationsService($repository, $translator);

// Test with different prefixes
$testCases = [
    ['prefix' => 'Hot', 'locale' => 'en', 'description' => 'English - Hotels starting with "Hot"'],
    ['prefix' => 'Hot', 'locale' => 'es', 'description' => 'Spanish - Hotels starting with "Hot"'],
    ['prefix' => 'Apa', 'locale' => 'en', 'description' => 'English - Apartments starting with "Apa"'],
    ['prefix' => 'Apa', 'locale' => 'es', 'description' => 'Spanish - Apartments starting with "Apa"'],
];

foreach ($testCases as $test) {
    echo "--- " . $test['description'] . " ---\n";
    $results = $service->execute($test['prefix'], $test['locale']);
    
    if (empty($results)) {
        echo "No results found.\n";
    } else {
        foreach ($results as $result) {
            echo $result . "\n";
        }
    }
    echo "\n";
}

echo "=== Demo Complete ===\n";
echo "The application successfully:\n";
echo "- Searches accommodations by name prefix\n";
echo "- Formats output with localized labels\n";
echo "- Supports multiple languages (en, es)\n";
echo "- Uses clean architecture with dependency injection\n";
echo "- Handles both hotels and apartments\n";
