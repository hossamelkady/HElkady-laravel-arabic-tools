<?php

namespace HossamElkady\ArabicTools;

use HossamElkady\ArabicTools\Support\Digits;
use HossamElkady\ArabicTools\Support\Slug;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ArabicToolsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ArabicTools::class);
    }

    public function boot(): void
    {
        // Str::arabicSlug('عنوان المقال'), Str::arabicDigits(2026), Str::arabicWords(250)
        Str::macro('arabicSlug', fn (string $text, string $sep = '-') => Slug::make($text, $sep));
        Str::macro('arabicDigits', fn ($value) => Digits::toArabicIndic($value));
        Str::macro('arabicWords', fn (int $n) => app(ArabicTools::class)->numberToWords($n));
    }
}
