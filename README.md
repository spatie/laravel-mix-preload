# Add preload and prefetch links based your Mix manifest

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-mix-preload.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mix-preload)
[![Build Status](https://img.shields.io/travis/spatie/laravel-mix-preload/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-mix-preload)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-mix-preload.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-mix-preload)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-mix-preload.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mix-preload)

```blade
<head>
    <title>Preloading things</title>

    @preload
</head>
```

This package exposes a `@preload` Blade directive that renders preload and prefetch links based on the contents in `mix-manifest.json`. Declaring what should be preloaded or prefetched is simple, just make sure `preload` or `prefetch` is part of the chunk name.

If this is your mix manifest:

```json
{
    "/js/app.js": "/js/app.js",
    "/css/app.css": "/css/app.css",
    "/css/prefetch-otherpagecss.css": "/css/prefetch-otherpagecss.css",
    "/js/preload-biglibrary.js": "/js/preload-biglibrary.js",
    "/js/vendors~preload-biglibrary.js": "/js/vendors~preload-biglibrary.js"
}
```

The following links will be rendered:

```html
<link rel="prefetch" href="/css/prefetch-otherpagecss.css" as="style">
<link rel="preload" href="/js/preload-biglibrary.js" as="script">
<link rel="preload" href="/js/vendors~preload-biglibrary.js" as="script">
```

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-mix-preload
```

## Usage

Add a `@preload` directive to your applications layout file(s).

```blade
<!doctype html>
<html>
    <head>
        ...
        @preload
    </head>
    <body>
        ...
    </body>
</html>
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie).
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
