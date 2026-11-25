<?php

namespace HossamElkady\ArabicTools\Tests;

use HossamElkady\ArabicTools\Facades\Arabic;

class NumberToWordsTest extends TestCase
{
    public function test_basic_numbers(): void
    {
        $this->assertSame('صفر', Arabic::numberToWords(0));
        $this->assertSame('خمسة', Arabic::numberToWords(5));
        $this->assertSame('أحد عشر', Arabic::numberToWords(11));
        $this->assertSame('واحد وعشرون', Arabic::numberToWords(21));
        $this->assertSame('تسعة وتسعون', Arabic::numberToWords(99));
    }

    public function test_hundreds_and_thousands(): void
    {
        $this->assertSame('مائة', Arabic::numberToWords(100));
        $this->assertSame('مائتان', Arabic::numberToWords(200));
        $this->assertSame('ثلاثمائة وخمسة وأربعون', Arabic::numberToWords(345));
        $this->assertSame('ألف', Arabic::numberToWords(1000));
        $this->assertSame('ألفان', Arabic::numberToWords(2000));
        $this->assertSame('ثلاثة آلاف', Arabic::numberToWords(3000));
        $this->assertSame('أحد عشر ألف', Arabic::numberToWords(11000));
        $this->assertSame('ألف ومائتان وخمسون', Arabic::numberToWords(1250));
    }

    public function test_millions(): void
    {
        $this->assertSame('مليون', Arabic::numberToWords(1_000_000));
        $this->assertSame('مليونان', Arabic::numberToWords(2_000_000));
        $this->assertSame('خمسة ملايين وخمسمائة ألف', Arabic::numberToWords(5_500_000));
    }

    public function test_negative(): void
    {
        $this->assertSame('سالب خمسة', Arabic::numberToWords(-5));
    }

    public function test_money_egp(): void
    {
        $this->assertSame('جنيه مصري', Arabic::money(1));
        $this->assertSame('جنيهان مصريان', Arabic::money(2));
        $this->assertSame('ثلاثة جنيهات مصرية', Arabic::money(3));
        $this->assertSame('خمسة عشر جنيهاً مصرياً', Arabic::money(15));
        $this->assertSame(
            'ألف ومائتان وخمسون جنيهاً مصرياً وخمسة وسبعون قرشاً',
            Arabic::money(1250.75)
        );
        $this->assertSame('صفر جنيهاً مصرياً', Arabic::money(0));
    }

    public function test_unknown_currency(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Arabic::money(5, 'XXX');
    }

    public function test_money_kwd_uses_three_decimals(): void
    {
        $this->assertSame('دينار كويتي', Arabic::money(1, 'KWD'));
        $this->assertSame('ثلاثة دنانير كويتية', Arabic::money(3, 'KWD'));
        $this->assertSame('دينار كويتي وخمسة فلوس', Arabic::money(1.005, 'KWD'));
    }
}
