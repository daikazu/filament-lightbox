<?php

namespace Daikazu\FilamentLightbox;

use Filament\Contracts\Plugin;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class LightBoxPlugin implements Plugin
{
    use EvaluatesClosures;

    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return FilamentLightboxServiceProvider::$name;
    }

    public function register(Panel $panel): void
    {
        // TODO: Implement register() method.
    }

    public function boot(Panel $panel): void
    {

        ImageColumn::macro('lightbox', macro: function ($url = null) {
            $extraAttributes = $this->extraAttributes[0] ?? [];
            $extraImgAttributes = $this->extraImgAttributes[0] ?? [];

            /** @phpstan-ignore-next-line */
            return $this
                ->openUrlInNewTab()
                ->extraAttributes(array_merge($extraAttributes, ['x-on:click' => 'FilamentLightBox.open(event, \'' . $url . '\')']))
                ->extraImgAttributes(array_merge($extraImgAttributes, ['class' => 'filament-light-box-img-indicator']));

        });

        ImageEntry::macro('lightbox', macro: function ($url = null) {
            $extraAttributes = $this->extraAttributes[0] ?? [];
            $extraImgAttributes = $this->extraImgAttributes[0] ?? [];

            /** @phpstan-ignore-next-line */
            return $this
                ->openUrlInNewTab()
                ->extraAttributes(array_merge($extraAttributes, ['x-on:click' => 'FilamentLightBox.open(event, \'' . $url . '\')']))
                ->extraImgAttributes(array_merge($extraImgAttributes, ['class' => 'filament-light-box-img-indicator']));
        });

        TextColumn::macro('lightbox', macro: function ($url) {
            $extraAttributes = $this->extraAttributes[0] ?? [];

            /** @phpstan-ignore-next-line */
            return $this
                ->openUrlInNewTab()
                ->extraAttributes(array_merge($extraAttributes, ['x-on:click' => 'FilamentLightBox.open(event, \'' . $url . '\')']));
        });

        TextEntry::macro('lightbox', macro: function ($url) {
            $extraAttributes = $this->extraAttributes[0] ?? [];

            /** @phpstan-ignore-next-line */
            return $this
                ->openUrlInNewTab()
                ->extraAttributes(array_merge($extraAttributes, ['x-on:click' => 'FilamentLightBox.open(event, \'' . $url . '\')']));
        });

    }
}
