<?php

namespace HossamElkady\ArabicTools\Support;

use InvalidArgumentException;

/**
 * Converts integers and money amounts to Arabic words.
 * Supports up to 999,999,999,999,999 (hundreds of trillions is not needed in practice).
 */
class NumberToWords
{
    private const ONES = [
        0 => 'صفر', 1 => 'واحد', 2 => 'اثنان', 3 => 'ثلاثة', 4 => 'أربعة', 5 => 'خمسة',
        6 => 'ستة', 7 => 'سبعة', 8 => 'ثمانية', 9 => 'تسعة', 10 => 'عشرة',
        11 => 'أحد عشر', 12 => 'اثنا عشر', 13 => 'ثلاثة عشر', 14 => 'أربعة عشر', 15 => 'خمسة عشر',
        16 => 'ستة عشر', 17 => 'سبعة عشر', 18 => 'ثمانية عشر', 19 => 'تسعة عشر',
    ];

    private const TENS = [
        2 => 'عشرون', 3 => 'ثلاثون', 4 => 'أربعون', 5 => 'خمسون',
        6 => 'ستون', 7 => 'سبعون', 8 => 'ثمانون', 9 => 'تسعون',
    ];

    private const HUNDREDS = [
        1 => 'مائة', 2 => 'مائتان', 3 => 'ثلاثمائة', 4 => 'أربعمائة', 5 => 'خمسمائة',
        6 => 'ستمائة', 7 => 'سبعمائة', 8 => 'ثمانمائة', 9 => 'تسعمائة',
    ];

    /** [singular, dual, plural (3-10), accusative singular (11+)] */
    private const SCALES = [
        1 => ['ألف', 'ألفان', 'آلاف', 'ألف'],
        2 => ['مليون', 'مليونان', 'ملايين', 'مليون'],
        3 => ['مليار', 'ملياران', 'مليارات', 'مليار'],
        4 => ['تريليون', 'تريليونان', 'تريليونات', 'تريليون'],
    ];

    public function convert(int $number): string
    {
        if ($number < 0) {
            return 'سالب ' . $this->convert(-$number);
        }
        if ($number === 0) {
            return self::ONES[0];
        }
        if ($number > 999_999_999_999_999) {
            throw new InvalidArgumentException('Number is too large.');
        }

        $groups = [];
        $scale = 0;
        while ($number > 0) {
            $groups[$scale++] = $number % 1000;
            $number = intdiv($number, 1000);
        }

        $parts = [];
        for ($i = count($groups) - 1; $i >= 0; $i--) {
            $g = $groups[$i];
            if ($g === 0) {
                continue;
            }
            if ($i === 0) {
                $parts[] = $this->belowThousand($g);
                continue;
            }
            $s = self::SCALES[$i];
            if ($g === 1) {
                $parts[] = $s[0];
            } elseif ($g === 2) {
                $parts[] = $s[1];
            } elseif ($g >= 3 && $g <= 10) {
                $parts[] = $this->belowThousand($g) . ' ' . $s[2];
            } else {
                $parts[] = $this->belowThousand($g) . ' ' . $s[3];
            }
        }

        return implode(' و', $parts);
    }

    /**
     * Money: 1250.75 EGP => "ألف ومائتان وخمسون جنيهاً مصرياً وخمسة وسبعون قرشاً".
     * Currencies: EGP, SAR, AED, USD, KWD (3 decimals not supported, uses 2).
     */
    public function money(float|int|string $amount, string $currency = 'EGP'): string
    {
        $cur = Currencies::get($currency);
        $amount = number_format((float) $amount, 2, '.', '');
        [$whole, $fraction] = explode('.', $amount);
        $whole = (int) $whole;
        $fraction = (int) $fraction;

        $out = [];
        if ($whole > 0 || $fraction === 0) {
            $out[] = $this->counted($whole, $cur['major']);
        }
        if ($fraction > 0) {
            $out[] = $this->counted($fraction, $cur['minor']);
        }

        return implode(' و', $out);
    }

    /** [singular, dual, plural 3-10, accusative singular 11+] */
    private function counted(int $n, array $unit): string
    {
        if ($n === 0) {
            return 'صفر ' . $unit[3];
        }
        if ($n === 1) {
            return $unit[0];
        }
        if ($n === 2) {
            return $unit[1];
        }
        $words = $this->convert($n);
        $last = $n % 100; // the counted noun follows the last two digits
        if ($last >= 3 && $last <= 10) {
            return $words . ' ' . $unit[2];
        }
        return $words . ' ' . $unit[3];
    }

    private function belowThousand(int $n): string
    {
        $parts = [];
        $h = intdiv($n, 100);
        $rest = $n % 100;

        if ($h > 0) {
            $parts[] = self::HUNDREDS[$h];
        }
        if ($rest > 0) {
            if ($rest < 20) {
                $parts[] = self::ONES[$rest];
            } else {
                $unit = $rest % 10;
                $ten = intdiv($rest, 10);
                if ($unit > 0) {
                    $parts[] = self::ONES[$unit] . ' و' . self::TENS[$ten];
                } else {
                    $parts[] = self::TENS[$ten];
                }
            }
        }

        return implode(' و', $parts);
    }
}
