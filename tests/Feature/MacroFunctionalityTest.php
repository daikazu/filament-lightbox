<?php

use Daikazu\FilamentLightbox\LightBoxPlugin;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Panel;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

describe('Macro Functionality', function () {
    beforeEach(function () {
        $panel = Panel::make()->id('admin');
        $plugin = LightBoxPlugin::make();
        $plugin->boot($panel);
    });

    describe('ImageColumn::lightbox()', function () {
        it('adds x-on:click attribute without url parameter', function () {
            $column = ImageColumn::make('image')
                ->lightbox();

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event');
        });

        it('adds x-on:click attribute with url parameter', function () {
            $url = 'https://example.com/image.jpg';
            $column = ImageColumn::make('image')
                ->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event')
                ->and($attributes['x-on:click'])->toContain($url);
        });

        it('adds filament-light-box-img-indicator class to image', function () {
            $column = ImageColumn::make('image')
                ->lightbox();

            $imgAttributes = $column->getExtraImgAttributes();

            expect($imgAttributes)
                ->toBeArray()
                ->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });

        it('preserves existing extra attributes', function () {
            $column = ImageColumn::make('image')
                ->extraAttributes(['data-test' => 'value'])
                ->lightbox();

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toHaveKey('data-test')
                ->and($attributes['data-test'])->toBe('value')
                ->and($attributes)->toHaveKey('x-on:click');
        });

        it('preserves existing extra image attributes', function () {
            $column = ImageColumn::make('image')
                ->extraImgAttributes(['alt' => 'Test Image'])
                ->lightbox();

            $imgAttributes = $column->getExtraImgAttributes();

            expect($imgAttributes)
                ->toHaveKey('alt')
                ->and($imgAttributes['alt'])->toBe('Test Image')
                ->and($imgAttributes)->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });

        it('enables openUrlInNewTab', function () {
            $column = ImageColumn::make('image')
                ->lightbox();

            expect($column->shouldOpenUrlInNewTab())->toBeTrue();
        });

        it('can be chained with other methods', function () {
            $column = ImageColumn::make('image')
                ->circular()
                ->lightbox()
                ->size(100);

            $attributes = $column->getExtraAttributes();

            expect($column)
                ->toBeInstanceOf(ImageColumn::class)
                ->and($attributes)->toHaveKey('x-on:click');
        });
    });

    describe('ImageEntry::lightbox()', function () {
        it('adds x-on:click attribute without url parameter', function () {
            $entry = ImageEntry::make('image')
                ->lightbox();

            $attributes = $entry->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event');
        });

        it('adds x-on:click attribute with url parameter', function () {
            $url = 'https://example.com/image.jpg';
            $entry = ImageEntry::make('image')
                ->lightbox($url);

            $attributes = $entry->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event')
                ->and($attributes['x-on:click'])->toContain($url);
        });

        it('adds filament-light-box-img-indicator class to image', function () {
            $entry = ImageEntry::make('image')
                ->lightbox();

            $imgAttributes = $entry->getExtraImgAttributes();

            expect($imgAttributes)
                ->toBeArray()
                ->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });

        it('preserves existing extra attributes', function () {
            $entry = ImageEntry::make('image')
                ->extraAttributes(['data-test' => 'value'])
                ->lightbox();

            $attributes = $entry->getExtraAttributes();

            expect($attributes)
                ->toHaveKey('data-test')
                ->and($attributes['data-test'])->toBe('value')
                ->and($attributes)->toHaveKey('x-on:click');
        });

        it('preserves existing extra image attributes', function () {
            $entry = ImageEntry::make('image')
                ->extraImgAttributes(['alt' => 'Test Image'])
                ->lightbox();

            $imgAttributes = $entry->getExtraImgAttributes();

            expect($imgAttributes)
                ->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });

        it('enables openUrlInNewTab', function () {
            $entry = ImageEntry::make('image')
                ->lightbox();

            expect($entry->shouldOpenUrlInNewTab())->toBeTrue();
        });
    });

    describe('TextColumn::lightbox()', function () {
        it('requires url parameter', function () {
            $url = 'https://example.com/image.jpg';
            $column = TextColumn::make('title')
                ->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event')
                ->and($attributes['x-on:click'])->toContain($url);
        });

        it('does not add img attributes', function () {
            $url = 'https://example.com/image.jpg';
            $column = TextColumn::make('title')
                ->lightbox($url);

            expect(method_exists($column, 'getExtraImgAttributes'))->toBeFalse();
        });

        it('preserves existing extra attributes', function () {
            $url = 'https://example.com/image.jpg';
            $column = TextColumn::make('title')
                ->extraAttributes(['class' => 'custom-class'])
                ->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toHaveKey('class')
                ->and($attributes['class'])->toBe('custom-class')
                ->and($attributes)->toHaveKey('x-on:click');
        });

        it('enables openUrlInNewTab', function () {
            $url = 'https://example.com/image.jpg';
            $column = TextColumn::make('title')
                ->lightbox($url);

            expect($column->shouldOpenUrlInNewTab())->toBeTrue();
        });

        it('can be chained with other methods', function () {
            $url = 'https://example.com/image.jpg';
            $column = TextColumn::make('title')
                ->searchable()
                ->lightbox($url)
                ->sortable();

            $attributes = $column->getExtraAttributes();

            expect($column)
                ->toBeInstanceOf(TextColumn::class)
                ->and($attributes)->toHaveKey('x-on:click');
        });
    });

    describe('TextEntry::lightbox()', function () {
        it('requires url parameter', function () {
            $url = 'https://example.com/image.jpg';
            $entry = TextEntry::make('title')
                ->lightbox($url);

            $attributes = $entry->getExtraAttributes();

            expect($attributes)
                ->toBeArray()
                ->toHaveKey('x-on:click')
                ->and($attributes['x-on:click'])->toContain('FilamentLightBox.open(event')
                ->and($attributes['x-on:click'])->toContain($url);
        });

        it('does not add img attributes', function () {
            $url = 'https://example.com/image.jpg';
            $entry = TextEntry::make('title')
                ->lightbox($url);

            expect(method_exists($entry, 'getExtraImgAttributes'))->toBeFalse();
        });

        it('preserves existing extra attributes', function () {
            $url = 'https://example.com/image.jpg';
            $entry = TextEntry::make('title')
                ->extraAttributes(['class' => 'custom-class'])
                ->lightbox($url);

            $attributes = $entry->getExtraAttributes();

            expect($attributes)
                ->toHaveKey('class')
                ->and($attributes['class'])->toBe('custom-class')
                ->and($attributes)->toHaveKey('x-on:click');
        });

        it('enables openUrlInNewTab', function () {
            $url = 'https://example.com/image.jpg';
            $entry = TextEntry::make('title')
                ->lightbox($url);

            expect($entry->shouldOpenUrlInNewTab())->toBeTrue();
        });
    });

    describe('URL handling', function () {
        it('handles null url for ImageColumn', function () {
            $column = ImageColumn::make('image')
                ->lightbox(null);

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain('FilamentLightBox.open(event, \'\')');
        });

        it('handles null url for ImageEntry', function () {
            $entry = ImageEntry::make('image')
                ->lightbox(null);

            $attributes = $entry->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain('FilamentLightBox.open(event, \'\')');
        });

        it('handles special characters in url', function () {
            $url = 'https://example.com/image?size=large&format=jpg';
            $column = ImageColumn::make('image')
                ->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain($url);
        });

        it('handles urls with single quotes', function () {
            $url = "https://example.com/o'reilly.jpg";
            $column = ImageColumn::make('image')
                ->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain($url);
        });
    });
});
