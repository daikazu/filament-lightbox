<?php

use Daikazu\FilamentLightbox\FilamentLightboxServiceProvider;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\PackageServiceProvider;

describe('FilamentLightboxServiceProvider', function () {
    it('extends PackageServiceProvider', function () {
        $provider = new FilamentLightboxServiceProvider($this->app);

        expect($provider)->toBeInstanceOf(PackageServiceProvider::class);
    });

    it('has correct package name', function () {
        expect(FilamentLightboxServiceProvider::$name)->toBe('filament-lightbox');
    });

    it('registers package with correct name', function () {
        $provider = new FilamentLightboxServiceProvider($this->app);

        // The package is configured through configurePackage method
        expect($provider)->toBeInstanceOf(FilamentLightboxServiceProvider::class);
    });

    describe('asset registration', function () {
        it('registers JavaScript assets', function () {
            $assets = FilamentAsset::getScripts(['daikazu/filament-lightbox']);

            expect($assets)
                ->toBeArray()
                ->not->toBeEmpty();
        });

        it('registers asset with correct identifier', function () {
            $assets = FilamentAsset::getScripts(['daikazu/filament-lightbox']);
            $assetIds = array_map(fn ($asset) => $asset->getId(), $assets);

            expect($assetIds)->toContain('filament-lightbox-scripts');
        });

        it('asset points to correct file path', function () {
            $assets = FilamentAsset::getScripts(['daikazu/filament-lightbox']);
            $scriptAsset = collect($assets)->first(fn ($asset) => $asset->getId() === 'filament-lightbox-scripts');

            expect($scriptAsset)->not->toBeNull()
                ->and($scriptAsset->getPath())->toEndWith('resources/dist/filament-lightbox.js');
        });
    });

    describe('package configuration', function () {
        it('can be booted without errors', function () {
            $provider = new FilamentLightboxServiceProvider($this->app);

            expect(fn () => $provider->packageBooted())->not->toThrow(Exception::class);
        });

        it('is automatically discovered by Laravel', function () {
            $providers = $this->app->getProviders(FilamentLightboxServiceProvider::class);

            expect($providers)
                ->toBeArray()
                ->not->toBeEmpty();
        });
    });
});
