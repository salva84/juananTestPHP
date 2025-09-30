<?php
declare(strict_types=1);

namespace App\Domain;

class Apartment extends Accommodation
{
    public function __construct(
        int $id,
        string $name,
        Location $location,
        private readonly int $numUnits,
        private readonly int $capacityAdults
    ) {
        parent::__construct($id, $name, $location);
    }

    public function getNumUnits(): int
    {
        return $this->numUnits;
    }

    public function getCapacityAdults(): int
    {
        return $this->capacityAdults;
    }

    public function getType(): AccommodationType
    {
        return AccommodationType::APARTMENT;
    }

    public function getDisplayName(): string
    {
        return 'Apartments ' . $this->getName();
    }
}
