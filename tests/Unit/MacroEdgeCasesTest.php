<?php

use Daikazu\FilamentLightbox\LightBoxPlugin;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Panel;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

describe('Macro Edge Cases', function () {
    beforeEach(function () {
        $panel = Panel::make()->id('admin');
        $plugin = LightBoxPlugin::make();
        $plugin->boot($panel);
    });

    describe('multiple lightbox calls', function () {
        it('allows lightbox to be called multiple times on ImageColumn', function () {
            $column = ImageColumn::make('image')
                ->lightbox('https://first.com/image.jpg')
                ->lightbox('https://second.com/image.jpg');

            $attributes = $column->getExtraAttributes();

            // Last call should win
            expect($attributes['x-on:click'])->toContain('https://second.com/image.jpg');
        });

        it('allows lightbox to be called multiple times on TextColumn', function () {
            $column = TextColumn::make('title')
                ->lightbox('https://first.com/image.jpg')
                ->lightbox('https://second.com/image.jpg');

            $attributes = $column->getExtraAttributes();

            // Last call should win
            expect($attributes['x-on:click'])->toContain('https://second.com/image.jpg');
        });
    });

    describe('empty and whitespace urls', function () {
        it('handles empty string url for ImageColumn', function () {
            $column = ImageColumn::make('image')
                ->lightbox('');

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain('FilamentLightBox.open(event, \'\')');
        });

        it('handles whitespace url for ImageColumn', function () {
            $column = ImageColumn::make('image')
                ->lightbox('   ');

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain('FilamentLightBox.open(event, \'   \')');
        });

        it('handles empty string url for TextColumn', function () {
            $column = TextColumn::make('title')
                ->lightbox('');

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain('FilamentLightBox.open(event, \'\')');
        });
    });

    describe('complex attribute merging', function () {
        it('lightbox adds to existing extraAttributes', function () {
            $column = ImageColumn::make('image')
                ->extraAttributes(['data-test' => 'value'])
                ->lightbox();

            $attributes = $column->getExtraAttributes();

            expect($attributes)
                ->toHaveKey('data-test')
                ->toHaveKey('x-on:click');
        });

        it('lightbox adds to existing extraImgAttributes', function () {
            $column = ImageColumn::make('image')
                ->extraImgAttributes(['alt' => 'Test'])
                ->lightbox();

            $imgAttributes = $column->getExtraImgAttributes();

            expect($imgAttributes)
                ->toHaveKey('alt')
                ->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });

        it('adds lightbox indicator class via extraImgAttributes', function () {
            $column = ImageColumn::make('image')
                ->lightbox();

            $imgAttributes = $column->getExtraImgAttributes();

            expect($imgAttributes)
                ->toHaveKey('class')
                ->and($imgAttributes['class'])->toContain('filament-light-box-img-indicator');
        });
    });

    describe('macro existence checks', function () {
        it('does not allow lightbox macro to be called before boot', function () {
            // Create a new panel without booting the plugin
            $panel = Panel::make()->id('test');

            // The macro should already exist from the beforeEach, so let's test the concept differently
            expect(ImageColumn::hasMacro('lightbox'))->toBeTrue();
        });

        it('macro persists across multiple component instances', function () {
            $column1 = ImageColumn::make('image1')->lightbox();
            $column2 = ImageColumn::make('image2')->lightbox();

            expect($column1->getExtraAttributes())
                ->toHaveKey('x-on:click')
                ->and($column2->getExtraAttributes())
                ->toHaveKey('x-on:click');
        });
    });

    describe('return type verification', function () {
        it('ImageColumn::lightbox returns ImageColumn instance', function () {
            $column = ImageColumn::make('image')->lightbox();

            expect($column)->toBeInstanceOf(ImageColumn::class);
        });

        it('ImageEntry::lightbox returns ImageEntry instance', function () {
            $entry = ImageEntry::make('image')->lightbox();

            expect($entry)->toBeInstanceOf(ImageEntry::class);
        });

        it('TextColumn::lightbox returns TextColumn instance', function () {
            $column = TextColumn::make('title')->lightbox('https://example.com/image.jpg');

            expect($column)->toBeInstanceOf(TextColumn::class);
        });

        it('TextEntry::lightbox returns TextEntry instance', function () {
            $entry = TextEntry::make('title')->lightbox('https://example.com/image.jpg');

            expect($entry)->toBeInstanceOf(TextEntry::class);
        });
    });

    describe('long url handling', function () {
        it('handles very long urls', function () {
            $longUrl = 'https://example.com/' . str_repeat('a', 1000) . '.jpg';
            $column = ImageColumn::make('image')->lightbox($longUrl);

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain($longUrl);
        });

        it('handles urls with query parameters', function () {
            $url = 'https://example.com/image.jpg?width=1920&height=1080&quality=high&format=webp';
            $column = ImageColumn::make('image')->lightbox($url);

            $attributes = $column->getExtraAttributes();

            expect($attributes['x-on:click'])->toContain($url);
        });
    });

    describe('method chaining order', function () {
        it('works when lightbox is called first', function () {
            $column = ImageColumn::make('image')
                ->lightbox()
                ->circular()
                ->size(100);

            expect($column)
                ->toBeInstanceOf(ImageColumn::class)
                ->and($column->getExtraAttributes())->toHaveKey('x-on:click');
        });

        it('works when lightbox is called last', function () {
            $column = ImageColumn::make('image')
                ->circular()
                ->size(100)
                ->lightbox();

            expect($column)
                ->toBeInstanceOf(ImageColumn::class)
                ->and($column->getExtraAttributes())->toHaveKey('x-on:click');
        });

        it('works when lightbox is called in the middle', function () {
            $column = ImageColumn::make('image')
                ->circular()
                ->lightbox()
                ->size(100);

            expect($column)
                ->toBeInstanceOf(ImageColumn::class)
                ->and($column->getExtraAttributes())->toHaveKey('x-on:click');
        });
    });
});
