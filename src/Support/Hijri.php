<?php

namespace HossamElkady\ArabicTools\Support;

use DateTimeInterface;

/**
 * Tabular (arithmetical) Islamic calendar. It can be off by one day from the
 * moon-sighting or Umm al-Qura calendars. Do not use it for religious rulings.
 */
class Hijri
{
    public const MONTHS = [
        1 => 'محرم', 2 => 'صفر', 3 => 'ربيع الأول', 4 => 'ربيع الآخر', 5 => 'جمادى الأولى',
        6 => 'جمادى الآخرة', 7 => 'رجب', 8 => 'شعبان', 9 => 'رمضان', 10 => 'شوال',
        11 => 'ذو القعدة', 12 => 'ذو الحجة',
    ];

    /** @return array{year:int, month:int, day:int} */
    public static function fromGregorian(DateTimeInterface $date): array
    {
        $jd = self::gregorianToJd((int) $date->format('Y'), (int) $date->format('n'), (int) $date->format('j'));
        $l = $jd - 1948440 + 10632;
        $n = intdiv($l - 1, 10631);
        $l = $l - 10631 * $n + 354;
        $j = intdiv(10985 - $l, 5316) * intdiv(50 * $l, 17719) + intdiv($l, 5670) * intdiv(43 * $l, 15238);
        $l = $l - intdiv(30 - $j, 15) * intdiv(17719 * $j, 50) - intdiv($j, 16) * intdiv(15238 * $j, 43) + 29;
        $month = intdiv(24 * $l, 709);
        $day = $l - intdiv(709 * $month, 24);
        $year = 30 * $n + $j - 30;

        return ['year' => $year, 'month' => $month, 'day' => $day];
    }

    public static function format(DateTimeInterface $date, bool $arabicDigits = true): string
    {
        $h = self::fromGregorian($date);
        $text = $h['day'] . ' ' . self::MONTHS[$h['month']] . ' ' . $h['year'] . ' هـ';

        return $arabicDigits ? Digits::toArabicIndic($text) : $text;
    }

    private static function gregorianToJd(int $y, int $m, int $d): int
    {
        $a = intdiv(14 - $m, 12);
        $y2 = $y + 4800 - $a;
        $m2 = $m + 12 * $a - 3;

        return $d + intdiv(153 * $m2 + 2, 5) + 365 * $y2 + intdiv($y2, 4) - intdiv($y2, 100) + intdiv($y2, 400) - 32045;
    }
}
