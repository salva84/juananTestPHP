<?php
declare(strict_types=1);

namespace App\Domain;

enum RoomType: string
{
    case SINGLE = 'single';
    case DOUBLE = 'double';
    case DOUBLE_VIEW = 'double_view';
    case SUITE = 'suite';
    case FAMILY = 'family';
}
