<?php
declare(strict_types=1);

namespace App\Tests\Integration\Persistence;

use App\Domain\AccommodationType;
use App\Domain\Apartment;
use App\Domain\Hotel;
use App\Domain\RoomType;
use App\Infrastructure\Persistence\PdoAccommodationRepository;
use PDO;
use PHPUnit\Framework\TestCase;

/**
 * @group integration
 */
class PdoAccommodationRepositoryTest extends TestCase
{
    private PDO $pdo;
    private PdoAccommodationRepository $repository;

    protected function setUp(): void
    {
        // Use test database configuration
        $config = [
            'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=accommodations_test;charset=utf8mb4',
            'user' => 'accom_user',
            'password' => 'accom_password',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ],
        ];

        $this->pdo = new PDO(
            $config['dsn'],
            $config['user'],
            $config['password'],
            $config['options']
        );

        $this->pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
        $this->repository = new PdoAccommodationRepository($this->pdo);

        $this->seedTestData();
    }

    protected function tearDown(): void
    {
        $this->pdo->exec("DELETE FROM hotel_details");
        $this->pdo->exec("DELETE FROM apartment_details");
        $this->pdo->exec("DELETE FROM accommodation");
    }

    public function testSearchByNamePrefixReturnsHotels(): void
    {
        $results = $this->repository->searchByNamePrefix('Hot');
        
        $this->assertNotEmpty($results);
        
        $hotel = $results[0];
        $this->assertInstanceOf(Hotel::class, $hotel);
        $this->assertEquals(AccommodationType::HOTEL, $hotel->getType());
        $this->assertStringStartsWith('Hotel', $hotel->getName());
    }

    public function testSearchByNamePrefixReturnsApartments(): void
    {
        $results = $this->repository->searchByNamePrefix('Apa');
        
        $this->assertNotEmpty($results);
        
        $apartment = $results[0];
        $this->assertInstanceOf(Apartment::class, $apartment);
        $this->assertEquals(AccommodationType::APARTMENT, $apartment->getType());
        $this->assertStringStartsWith('Apartamentos', $apartment->getName());
    }

    public function testSearchByNamePrefixWithLimit(): void
    {
        $results = $this->repository->searchByNamePrefix('H', 1);
        
        $this->assertCount(1, $results);
    }

    public function testSearchByNamePrefixWithUnicodeNames(): void
    {
        $results = $this->repository->searchByNamePrefix('فندق');
        
        $this->assertNotEmpty($results);
        $this->assertStringStartsWith('فندق', $results[0]->getName());
    }

    private function seedTestData(): void
    {
        // Insert test accommodations
        $this->pdo->exec("
            INSERT INTO accommodation (type, name, city, province) VALUES
            ('hotel', 'Hotel Test', 'Valencia', 'Valencia'),
            ('apartment', 'Apartamentos Test', 'Almeria', 'Almeria'),
            ('hotel', 'فندق النور', 'دبي', 'دبي')
        ");

        // Insert hotel details
        $hotelId = $this->pdo->lastInsertId();
        $this->pdo->exec("
            INSERT INTO hotel_details (accommodation_id, stars, standard_room_type) VALUES
            ($hotelId, 3, 'double_view'),
            ($hotelId + 2, 5, 'suite')
        ");

        // Insert apartment details
        $this->pdo->exec("
            INSERT INTO apartment_details (accommodation_id, num_units, capacity_adults) VALUES
            ($hotelId + 1, 10, 4)
        ");
    }
}
