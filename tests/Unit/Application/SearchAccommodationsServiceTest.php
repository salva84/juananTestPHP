<?php
declare(strict_types=1);

namespace App\Tests\Unit\Application;

use App\Application\SearchAccommodationsService;
use App\Domain\Accommodation;
use App\Domain\AccommodationRepository;
use App\Domain\Apartment;
use App\Domain\Hotel;
use App\Domain\Location;
use App\Domain\RoomType;
use App\Infrastructure\I18n\Translator;
use PHPUnit\Framework\TestCase;

class SearchAccommodationsServiceTest extends TestCase
{
    private SearchAccommodationsService $service;
    private AccommodationRepository $repository;
    private Translator $translator;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(AccommodationRepository::class);
        $this->translator = $this->createMock(Translator::class);
        $this->service = new SearchAccommodationsService($this->repository, $this->translator);
    }

    public function testExecuteWithShortPrefixReturnsEmpty(): void
    {
        $result = $this->service->execute('Ho', 'en');
        
        $this->assertEquals([], $result);
    }

    public function testExecuteWithValidPrefixReturnsFormattedResults(): void
    {
        $location = new Location('Valencia', 'Valencia');
        $hotel = new Hotel(1, 'Hotel Azul', $location, 3, RoomType::DOUBLE_VIEW);
        $apartment = new Apartment(2, 'Apartamentos Beach', $location, 10, 4);
        
        $this->repository->expects($this->once())
            ->method('searchByNamePrefix')
            ->with('Hot')
            ->willReturn([$hotel, $apartment]);

        $this->translator->expects($this->exactly(4))
            ->method('translate')
            ->willReturnMap([
                ['labels.stars', 'en', 'stars'],
                ['roomTypes.double_view', 'en', 'double with view'],
                ['labels.standard_room', 'en', 'standard room'],
                ['labels.apartments', 'en', 'apartments'],
                ['labels.adults', 'en', 'adults'],
            ]);

        $result = $this->service->execute('Hot', 'en');
        
        $this->assertCount(2, $result);
        $this->assertStringContains('Hotel Hotel Azul', $result[0]);
        $this->assertStringContains('3 stars', $result[0]);
        $this->assertStringContains('double with view', $result[0]);
        $this->assertStringContains('Valencia, Valencia', $result[0]);
        
        $this->assertStringContains('Apartments Apartamentos Beach', $result[1]);
        $this->assertStringContains('10 apartments', $result[1]);
        $this->assertStringContains('4 adults', $result[1]);
    }
}
