<?php

use Daikazu\FilamentLightbox\LightBoxPlugin;
use Filament\Contracts\Plugin;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Panel;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

describe('LightBoxPlugin', function () {
    beforeEach(function () {
        $this->panel = Panel::make()->id('admin');
    });

    it('can be instantiated', function () {
        $plugin = LightBoxPlugin::make();

        expect($plugin)->toBeInstanceOf(LightBoxPlugin::class);
    });

    it('implements the Plugin interface', function () {
        $plugin = LightBoxPlugin::make();

        expect($plugin)->toBeInstanceOf(Plugin::class);
    });

    it('returns correct plugin ID', function () {
        $plugin = LightBoxPlugin::make();

        expect($plugin->getId())->toBe('filament-lightbox');
    });

    it('can be registered with a panel', function () {
        $plugin = LightBoxPlugin::make();

        expect(fn () => $plugin->register($this->panel))->not->toThrow(Exception::class);
    });

    describe('macro registration', function () {
        beforeEach(function () {
            $plugin = LightBoxPlugin::make();
            $plugin->boot($this->panel);
        });

        it('registers lightbox macro on ImageColumn', function () {
            expect(ImageColumn::hasMacro('lightbox'))->toBeTrue();
        });

        it('registers lightbox macro on ImageEntry', function () {
            expect(ImageEntry::hasMacro('lightbox'))->toBeTrue();
        });

        it('registers lightbox macro on TextColumn', function () {
            expect(TextColumn::hasMacro('lightbox'))->toBeTrue();
        });

        it('registers lightbox macro on TextEntry', function () {
            expect(TextEntry::hasMacro('lightbox'))->toBeTrue();
        });
    });
});
