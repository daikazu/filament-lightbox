<?php

namespace Daikazu\FilamentLightbox\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Daikazu\FilamentLightbox\FilamentLightbox
 */
class FilamentLightbox extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Daikazu\FilamentLightbox\FilamentLightbox::class;
    }
}
