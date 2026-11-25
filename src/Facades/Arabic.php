<?php

namespace HossamElkady\ArabicTools\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string numberToWords(int $number)
 * @method static string money(float|int|string $amount, string $currency = 'EGP')
 * @method static string digits(string|int|float $value)
 * @method static string westernDigits(string $value)
 * @method static string slug(string $text, string $separator = '-')
 * @method static string hijri(\DateTimeInterface $date, bool $arabicDigits = true)
 */
class Arabic extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \HossamElkady\ArabicTools\ArabicTools::class;
    }
}
