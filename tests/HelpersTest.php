<?php

namespace HossamElkady\ArabicTools\Tests;

use DateTimeImmutable;
use HossamElkady\ArabicTools\Facades\Arabic;
use Illuminate\Support\Str;

class HelpersTest extends TestCase
{
    public function test_digits(): void
    {
        $this->assertSame('٢٠٢٦', Arabic::digits(2026));
        $this->assertSame('2026', Arabic::westernDigits('٢٠٢٦'));
        $this->assertSame('123', Arabic::westernDigits('۱۲۳'));
    }

    public function test_slug(): void
    {
        $this->assertSame('مقال-عن-لارافيل-2026', Arabic::slug('مقال عن لارافيل ٢٠٢٦!'));
        $this->assertSame('hello-world', Arabic::slug('Hello, World'));
        $this->assertSame('كتاب', Arabic::slug('كِتَاب'));
        $this->assertSame('احمد', Arabic::slug('أحمد'));
    }

    public function test_str_macros(): void
    {
        $this->assertSame('مرحبا-بالعالم', Str::arabicSlug('مرحبا بالعالم'));
        $this->assertSame('١٢٣', Str::arabicDigits(123));
        $this->assertSame('مائة', Str::arabicWords(100));
    }

    public function test_global_helpers(): void
    {
        $this->assertSame('خمسة', arabic_words(5));
        $this->assertSame('٧', arabic_digits(7));
    }

    public function test_hijri_known_date(): void
    {
        // 1 Muharram 1447 AH is around 26 June 2025 (tabular calendar may differ by one day).
        $h = \HossamElkady\ArabicTools\Support\Hijri::fromGregorian(new DateTimeImmutable('2025-06-27'));
        $this->assertSame(1447, $h['year']);
        $this->assertSame(1, $h['month']);
        $this->assertEqualsWithDelta(1, $h['day'], 1);
    }

    public function test_hijri_format(): void
    {
        $text = Arabic::hijri(new DateTimeImmutable('2025-06-27'), false);
        $this->assertStringContainsString('محرم 1447', $text);
    }
}
