# package-skeleton

[简体中文](README_zh_CN.md) | [ENGLISH](README.md)

> A PHP package template repository. - 一个 PHP 软件包模板存储库。

[![tests](https://github.com/guanguans/package-skeleton/workflows/tests/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![check & fix styling](https://github.com/guanguans/package-skeleton/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![codecov](https://codecov.io/gh/guanguans/package-skeleton/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/package-skeleton)
[![Latest Stable Version](https://poser.pugx.org/guanguans/package-skeleton/v)](//packagist.org/packages/guanguans/package-skeleton)
[![Total Downloads](https://poser.pugx.org/guanguans/package-skeleton/downloads)](//packagist.org/packages/guanguans/package-skeleton)
[![License](https://poser.pugx.org/guanguans/package-skeleton/license)](//packagist.org/packages/guanguans/package-skeleton)

## Requirement

* PHP >= 7.2

## Installation

``` bash
$ composer require guanguans/package-skeleton --prefer-dist -vvv
```

## Usage

1. replace `guanguans/package-skeleton` -> `vendorName/package-name`
2. replace `Guanguans\\PackageSkeleton` -> `VendorName\\PackageName`
3. replace `Guanguans\PackageSkeleton` -> `VendorName\PackageName`
4. replace `ityaozm@gmail.com` -> `your email`
5. execute `$ composer dumpautoload`

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
