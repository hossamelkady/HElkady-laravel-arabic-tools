<?php

namespace HossamElkady\ArabicTools;

use DateTimeInterface;
use HossamElkady\ArabicTools\Support\Digits;
use HossamElkady\ArabicTools\Support\Hijri;
use HossamElkady\ArabicTools\Support\NumberToWords;
use HossamElkady\ArabicTools\Support\Slug;

class ArabicTools
{
    public function numberToWords(int $number): string
    {
        return (new NumberToWords())->convert($number);
    }

    public function money(float|int|string $amount, string $currency = 'EGP'): string
    {
        return (new NumberToWords())->money($amount, $currency);
    }

    public function digits(string|int|float $value): string
    {
        return Digits::toArabicIndic($value);
    }

    public function westernDigits(string $value): string
    {
        return Digits::toWestern($value);
    }

    public function slug(string $text, string $separator = '-'): string
    {
        return Slug::make($text, $separator);
    }

    public function hijri(DateTimeInterface $date, bool $arabicDigits = true): string
    {
        return Hijri::format($date, $arabicDigits);
    }
}
