<?php

describe('Architecture', function () {
    it('does not use debugging functions', function () {
        expect(['dd', 'dump', 'ray'])
            ->each->not->toBeUsed();
    });

    it('ensures ServiceProvider extends correct base class', function () {
        expect('Daikazu\FilamentLightbox\FilamentLightboxServiceProvider')
            ->toExtend('Spatie\LaravelPackageTools\PackageServiceProvider');
    });

    it('ensures Plugin implements correct interface', function () {
        expect('Daikazu\FilamentLightbox\LightBoxPlugin')
            ->toImplement('Filament\Contracts\Plugin');
    });

    it('avoids using die or exit', function () {
        expect(['die', 'exit'])
            ->each->not->toBeUsed();
    });

    it('does not use deprecated PHP functions', function () {
        expect(['eval', 'create_function'])
            ->each->not->toBeUsed();
    });
});
