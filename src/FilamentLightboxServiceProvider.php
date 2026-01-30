<?php

namespace Daikazu\FilamentLightbox;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentLightboxServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-lightbox';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name);
    }

    public function packageBooted(): void
    {
        FilamentAsset::register(
            [
                JS::make('filament-lightbox-scripts', __DIR__ . '/../resources/dist/filament-lightbox.js'),
            ],
            'daikazu/filament-lightbox'
        );

    }
}
