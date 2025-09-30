<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Accommodation;
use App\Domain\AccommodationRepository;
use App\Domain\AccommodationType;
use App\Domain\Apartment;
use App\Domain\Hotel;
use App\Domain\Location;
use App\Domain\RoomType;
use PDO;

class PdoAccommodationRepository implements AccommodationRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return Accommodation[]
     */
    public function searchByNamePrefix(string $prefix, int $limit = 200): array
    {
        $sql = "
            SELECT 
                a.id,
                a.type,
                a.name,
                a.city,
                a.province,
                hd.stars,
                hd.standard_room_type,
                ad.num_units,
                ad.capacity_adults
            FROM accommodation a
            LEFT JOIN hotel_details hd ON a.id = hd.accommodation_id
            LEFT JOIN apartment_details ad ON a.id = ad.accommodation_id
            WHERE a.name LIKE :prefix
            ORDER BY a.name
            LIMIT :limit
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':prefix', $prefix . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $accommodations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $location = new Location($row['city'], $row['province']);
            
            if ($row['type'] === AccommodationType::HOTEL->value) {
                $accommodations[] = new Hotel(
                    (int) $row['id'],
                    $row['name'],
                    $location,
                    (int) $row['stars'],
                    RoomType::from($row['standard_room_type'])
                );
            } elseif ($row['type'] === AccommodationType::APARTMENT->value) {
                $accommodations[] = new Apartment(
                    (int) $row['id'],
                    $row['name'],
                    $location,
                    (int) $row['num_units'],
                    (int) $row['capacity_adults']
                );
            }
        }

        return $accommodations;
    }
}
