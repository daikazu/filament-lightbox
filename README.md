<picture>
   <source media="(prefers-color-scheme: dark)" srcset="art/header-dark.png">
   <img alt="Logo for Lightbox for Filament PHP" src="art/header-light.png">
</picture>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/daikazu/filament-lightbox.svg?style=flat-square)](https://packagist.org/packages/daikazu/filament-lightbox)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/daikazu/filament-lightbox/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/daikazu/filament-lightbox/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/daikazu/filament-lightbox/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/daikazu/filament-lightbox/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/daikazu/filament-lightbox.svg?style=flat-square)](https://packagist.org/packages/daikazu/filament-lightbox)


# Lightbox for Filament PHP

Lightbox to preview images in Filament PHP Tables and Information Panels that uses [fslightbox.js](https://fslightbox.com).


## Installation

You can install the package via composer:

```bash
composer require daikazu/filament-lightbox
```

## Usage

```php
public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->plugin(LightBoxPlugin::make())
}
```

```php
\Filament\Tables\Columns\ImageColumn::make('image')
                    ->lightbox()
```

```php
\Filament\Tables\Columns\TextColumn::make('pdf_url')
                    ->lightbox("Your Url address"),
```

```php
\Filament\Infolists\Components\ImageEntry::make('image')
                    ->lightbox()
```

```php
\Filament\Infolists\Components\TextEntry::make('text')
                    ->lightbox("Your Url address")
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mike Wall](https://github.com/daikazu)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
