<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    public function translate(?string $text, string $targetLocale): string
    {
        if (blank($text)) {
            return (string) $text;
        }

        if ($targetLocale === 'pt' || $targetLocale === 'pt_BR') {
            return $text;
        }

        $cacheKey = 'translation.' . $targetLocale . '.' . md5($text);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text, $targetLocale) {
            try {
                return (new GoogleTranslate($targetLocale))->translate($text) ?? $text;
            } catch (\Throwable) {
                return $text;
            }
        });
    }
}
