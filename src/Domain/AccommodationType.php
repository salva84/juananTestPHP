<?php
declare(strict_types=1);

namespace App\Domain;

enum AccommodationType: string
{
    case HOTEL = 'hotel';
    case APARTMENT = 'apartment';
}
