<?php
declare(strict_types=1);

namespace App\Domain;

class Hotel extends Accommodation
{
    public function __construct(
        int $id,
        string $name,
        Location $location,
        private readonly int $stars,
        private readonly RoomType $standardRoomType
    ) {
        parent::__construct($id, $name, $location);
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function getStandardRoomType(): RoomType
    {
        return $this->standardRoomType;
    }

    public function getType(): AccommodationType
    {
        return AccommodationType::HOTEL;
    }

    public function getDisplayName(): string
    {
        return 'Hotel ' . $this->getName();
    }
}
