<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\AccommodationType;
use App\Domain\Hotel;
use App\Domain\Location;
use App\Domain\RoomType;
use PHPUnit\Framework\TestCase;

class HotelTest extends TestCase
{
    public function testHotelCreation(): void
    {
        $location = new Location('Valencia', 'Valencia');
        $hotel = new Hotel(1, 'Hotel Azul', $location, 3, RoomType::DOUBLE_VIEW);
        
        $this->assertEquals(1, $hotel->getId());
        $this->assertEquals('Hotel Azul', $hotel->getName());
        $this->assertEquals($location, $hotel->getLocation());
        $this->assertEquals(3, $hotel->getStars());
        $this->assertEquals(RoomType::DOUBLE_VIEW, $hotel->getStandardRoomType());
        $this->assertEquals(AccommodationType::HOTEL, $hotel->getType());
        $this->assertEquals('Hotel Hotel Azul', $hotel->getDisplayName());
    }
}
