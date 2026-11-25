<?php

use HossamElkady\ArabicTools\ArabicTools;

if (!function_exists('arabic_words')) {
    function arabic_words(int $number): string
    {
        return (new ArabicTools())->numberToWords($number);
    }
}

if (!function_exists('arabic_money')) {
    function arabic_money(float|int|string $amount, string $currency = 'EGP'): string
    {
        return (new ArabicTools())->money($amount, $currency);
    }
}

if (!function_exists('arabic_digits')) {
    function arabic_digits(string|int|float $value): string
    {
        return (new ArabicTools())->digits($value);
    }
}

if (!function_exists('arabic_slug')) {
    function arabic_slug(string $text, string $separator = '-'): string
    {
        return (new ArabicTools())->slug($text, $separator);
    }
}
