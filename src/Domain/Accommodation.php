<?php
declare(strict_types=1);

namespace App\Domain;

abstract class Accommodation
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly Location $location
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    abstract public function getType(): AccommodationType;

    abstract public function getDisplayName(): string;
}
