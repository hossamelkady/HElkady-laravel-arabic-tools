# laravel-arabic-tools

Arabic helpers for Laravel: numbers to words (with Egyptian pounds), Arabic-Indic digits, Hijri dates, and clean Arabic slugs.

أدوات عربية لـ Laravel: تحويل الأرقام لكلمات (مع الجنيه المصري)، الأرقام الهندية، التاريخ الهجري، وروابط (slug) عربية نظيفة.

> Status: v0.1. Unit tests are written but have not been run yet. Check the Arabic grammar output for your use case before printing cheques or legal invoices.
> الحالة: إصدار تجريبي. التيستات مكتوبة بس لسه ما اتشغلتش. راجع الصياغة العربية قبل استخدامها في شيكات أو فواتير رسمية.

## Install

```bash
composer require hossamelkady/laravel-arabic-tools
```

## Usage

```php
use HossamElkady\ArabicTools\Facades\Arabic;

Arabic::numberToWords(1250);
// ألف ومائتان وخمسون

Arabic::money(1250.75);
// ألف ومائتان وخمسون جنيهاً مصرياً وخمسة وسبعون قرشاً

Arabic::money(25, 'SAR');   // EGP, SAR, AED, USD, KWD

Arabic::digits(2026);            // ٢٠٢٦
Arabic::westernDigits('٢٠٢٦');   // 2026

Arabic::slug('مقال عن لارافيل ٢٠٢٦');   // مقال-عن-لارافيل-2026

Arabic::hijri(now());            // ٢٦ جمادى الآخرة ١٤٤٨ هـ (example)
```

Helpers and `Str` macros:

```php
arabic_words(100);     // مائة
arabic_money(15);      // خمسة عشر جنيهاً مصرياً
arabic_digits(7);      // ٧
arabic_slug('عنوان');

Str::arabicSlug('مرحبا بالعالم');
Str::arabicDigits(123);
Str::arabicWords(250);
```

Use the slug in a model:

```php
$post->slug = Str::arabicSlug($post->title);
```

## Notes

- Number words follow standard Modern Standard Arabic counting rules: dual forms (ألفان، جنيهان), plural for 3 to 10 (ثلاثة آلاف، خمسة جنيهات), and singular accusative from 11 (أحد عشر ألف، خمسة عشر جنيهاً).
- Hijri dates use the tabular (arithmetical) Islamic calendar. It can differ by a day from Umm al-Qura or moon sighting. Do not use it for religious rulings.
- Slugs remove tashkeel and tatweel, normalize alef with hamza to plain alef, and convert Arabic digits to Western digits.

## Tests

```bash
composer install
composer test
```

## License

MIT
