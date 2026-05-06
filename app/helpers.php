<?php

use App\Services\TranslationService;

if (! function_exists('td')) {
    /**
     * Translate a string from PT-BR to the current app locale.
     */
    function td(?string $text): string
    {
        $locale = app()->getLocale();

        return app(TranslationService::class)->translate($text, $locale);
    }
}
