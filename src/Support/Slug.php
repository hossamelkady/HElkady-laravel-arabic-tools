<?php

namespace HossamElkady\ArabicTools\Support;

class Slug
{
    /**
     * Keeps Arabic letters, converts Arabic digits, removes tashkeel and tatweel.
     * "مقال عن لارافيل ٢٠٢٦" => "مقال-عن-لارافيل-2026"
     */
    public static function make(string $text, string $separator = '-'): string
    {
        $text = Digits::toWestern($text);
        // Remove tashkeel (harakat), superscript alef and tatweel.
        $text = preg_replace('/[\x{064B}-\x{065F}\x{0670}\x{0640}]/u', '', $text);
        // Normalize alef variants and alef maqsura / teh marbuta kept as is for readability.
        $text = preg_replace('/[\x{0622}\x{0623}\x{0625}]/u', 'ا', $text);
        $text = mb_strtolower($text);
        // Keep letters (Arabic + Latin) and digits, everything else becomes a separator.
        $text = preg_replace('/[^\p{L}\p{N}]+/u', $separator, $text);

        return trim($text, $separator);
    }
}
