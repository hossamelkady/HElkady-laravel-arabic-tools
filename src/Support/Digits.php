<?php

namespace HossamElkady\ArabicTools\Support;

class Digits
{
    private const WESTERN = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    private const EASTERN = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    private const PERSIAN = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    /** 2026 => ٢٠٢٦ */
    public static function toArabicIndic(string|int|float $value): string
    {
        return str_replace(self::WESTERN, self::EASTERN, (string) $value);
    }

    /** ٢٠٢٦ (or Persian digits) => 2026 */
    public static function toWestern(string $value): string
    {
        return str_replace(self::PERSIAN, self::WESTERN, str_replace(self::EASTERN, self::WESTERN, $value));
    }
}
