<?php
declare(strict_types=1);

namespace App\Domain;

class Location
{
    public function __construct(
        private readonly string $city,
        private readonly string $province
    ) {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getProvince(): string
    {
        return $this->province;
    }

    public function getFullLocation(): string
    {
        return $this->city . ', ' . $this->province;
    }
}
