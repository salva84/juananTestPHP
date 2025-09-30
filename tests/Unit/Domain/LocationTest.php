<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\Location;
use PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testLocationCreation(): void
    {
        $location = new Location('Valencia', 'Valencia');
        
        $this->assertEquals('Valencia', $location->getCity());
        $this->assertEquals('Valencia', $location->getProvince());
        $this->assertEquals('Valencia, Valencia', $location->getFullLocation());
    }

    public function testFullLocationFormat(): void
    {
        $location = new Location('Mojacar', 'Almeria');
        
        $this->assertEquals('Mojacar, Almeria', $location->getFullLocation());
    }
}
