<?php
declare(strict_types=1);

namespace App\Infrastructure\I18n;

interface TranslatorInterface
{
    public function translate(string $key, string $locale): string;
}
