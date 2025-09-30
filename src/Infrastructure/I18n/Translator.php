<?php
declare(strict_types=1);

namespace App\Infrastructure\I18n;

class Translator implements TranslatorInterface
{
    private array $catalogs = [];
    private string $fallbackLocale = 'en';

    public function __construct(private readonly string $i18nPath)
    {
    }

    public function translate(string $key, string $locale): string
    {
        $catalog = $this->loadCatalog($locale);
        
        $keys = explode('.', $key);
        $value = $catalog;
        
        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                // Fallback to English if key not found
                if ($locale !== $this->fallbackLocale) {
                    return $this->translate($key, $this->fallbackLocale);
                }
                return $key; // Return key if not found even in fallback
            }
            $value = $value[$k];
        }
        
        return is_string($value) ? $value : $key;
    }

    private function loadCatalog(string $locale): array
    {
        if (isset($this->catalogs[$locale])) {
            return $this->catalogs[$locale];
        }

        $filePath = $this->i18nPath . '/' . $locale . '.json';
        
        if (!file_exists($filePath)) {
            // Fallback to English
            if ($locale !== $this->fallbackLocale) {
                return $this->loadCatalog($this->fallbackLocale);
            }
            return [];
        }

        $content = file_get_contents($filePath);
        $catalog = json_decode($content, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON in catalog: $filePath");
        }

        $this->catalogs[$locale] = $catalog;
        return $catalog;
    }
}
