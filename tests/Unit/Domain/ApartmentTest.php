<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\AccommodationType;
use App\Domain\Apartment;
use App\Domain\Location;
use PHPUnit\Framework\TestCase;

class ApartmentTest extends TestCase
{
    public function testApartmentCreation(): void
    {
        $location = new Location('Almeria', 'Almeria');
        $apartment = new Apartment(1, 'Apartamentos Beach', $location, 10, 4);
        
        $this->assertEquals(1, $apartment->getId());
        $this->assertEquals('Apartamentos Beach', $apartment->getName());
        $this->assertEquals($location, $apartment->getLocation());
        $this->assertEquals(10, $apartment->getNumUnits());
        $this->assertEquals(4, $apartment->getCapacityAdults());
        $this->assertEquals(AccommodationType::APARTMENT, $apartment->getType());
        $this->assertEquals('Apartments Apartamentos Beach', $apartment->getDisplayName());
    }
}
