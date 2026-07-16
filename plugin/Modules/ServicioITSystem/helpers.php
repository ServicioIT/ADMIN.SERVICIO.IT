<?php
if (!function_exists('__bilingual')) {
    function __bilingual($content) {
        if (empty($content)) return '';
        $decoded = json_decode($content, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['es'])) {
            $locale = app()->getLocale();
            $lang = explode('_', $locale)[0];
            return $decoded[$lang] ?? $decoded['es'] ?? $content;
        }
        return $content;
    }
}
