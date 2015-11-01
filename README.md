# db

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This package provides common database related classes and interfaces and includes a default database implementation and a default connection pool implementation.

The interfaces define a thin wrapper for SQL statement execution using connection pools and split read and write connections. Different database platform implementations can provide specialized connection, result and statement builder classes.      

## Install

Via composer:

``` bash
$ composer require binsoul/db
```

## Testing

``` bash
$ composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/binsoul/db.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/binsoul/db.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/binsoul/db
[link-downloads]: https://packagist.org/packages/binsoul/db
[link-author]: https://github.com/binsoul
