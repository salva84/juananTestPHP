<?php
declare(strict_types=1);

namespace App\Domain;

interface AccommodationRepository
{
    /**
     * @return Accommodation[]
     */
    public function searchByNamePrefix(string $prefix, int $limit = 200): array;
}
