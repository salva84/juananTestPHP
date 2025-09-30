<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\Accommodation;
use App\Domain\AccommodationRepository;
use App\Infrastructure\I18n\Translator;

class SearchAccommodationsService
{
    public function __construct(
        private readonly AccommodationRepository $accommodationRepository,
        private readonly Translator $translator
    ) {
    }

    /**
     * @return string[]
     */
    public function execute(string $prefix, string $locale): array
    {
        if (strlen($prefix) < 3) {
            return [];
        }

        $accommodations = $this->accommodationRepository->searchByNamePrefix($prefix);
        
        return array_map(
            fn(Accommodation $accommodation) => $this->formatAccommodation($accommodation, $locale),
            $accommodations
        );
    }

    private function formatAccommodation(Accommodation $accommodation, string $locale): string
    {
        $name = $accommodation->getDisplayName();
        $location = $accommodation->getLocation()->getFullLocation();
        
        if ($accommodation instanceof \App\Domain\Hotel) {
            $stars = $this->translator->translate('labels.stars', $locale);
            $roomType = $this->translator->translate('roomTypes.' . $accommodation->getStandardRoomType()->value, $locale);
            $standardRoom = $this->translator->translate('labels.standard_room', $locale);
            
            return sprintf(
                '%s, %d %s, %s %s, %s',
                $name,
                $accommodation->getStars(),
                $stars,
                $standardRoom,
                $roomType,
                $location
            );
        }
        
        if ($accommodation instanceof \App\Domain\Apartment) {
            $apartments = $this->translator->translate('labels.apartments', $locale);
            $adults = $this->translator->translate('labels.adults', $locale);
            
            return sprintf(
                '%s, %d %s, %d %s, %s',
                $name,
                $accommodation->getNumUnits(),
                $apartments,
                $accommodation->getCapacityAdults(),
                $adults,
                $location
            );
        }
        
        return $name . ', ' . $location;
    }
}
