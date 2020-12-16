# Loyverse SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pashkevich/loyverse-sdk.svg?style=flat-square)](https://packagist.org/packages/pashkevich/loyverse-sdk)
[![Build Status](https://img.shields.io/travis/pashkevich/loyverse-sdk/master.svg?style=flat-square)](https://travis-ci.org/pashkevich/loyverse-sdk)
[![Quality Score](https://img.shields.io/scrutinizer/g/pashkevich/loyverse-sdk.svg?style=flat-square)](https://scrutinizer-ci.com/g/pashkevich/loyverse-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/pashkevich/loyverse-sdk.svg?style=flat-square)](https://packagist.org/packages/pashkevich/loyverse-sdk)
<a href="https://packagist.org/packages/pashkevich/loyverse-sdk"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>

A simple to use PHP class to work with the Loyverse API.

## Installation

To install the SDK in your project you need to require the package via composer:

```bash
composer require pashkevich/loyverse-sdk
```
To work with this package, firstly you **must** have a [Loyverse](https://loyverse.com/) account, and secondly you must create an API token through [Loyverse](https://loyverse.com/) itself.

## Usage

``` php
$loyverse = new Pashkevich\Loyverse\Loyverse(TOKEN_HERE);
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email siarheipashkveich@gmail.com instead of using the issue tracker.

## Credits

- [Sergey Pashkevich](https://github.com/siarheipashkevich)
- [All Contributors](../../contributors)

## License

Loyverse SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
