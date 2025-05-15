# package-skeleton

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [!NOTE]
> A PHP package template repository. - 一个 PHP 软件包模板存储库。

[![tests](https://github.com/guanguans/package-skeleton/workflows/tests/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![phpstan](https://github.com/guanguans/package-skeleton/actions/workflows/phpstan.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions/workflows/phpstan.yml)
[![check & fix styling](https://github.com/guanguans/package-skeleton/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![rector](https://github.com/guanguans/package-skeleton/actions/workflows/rector.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions/workflows/rector.yml)
[![codecov](https://codecov.io/gh/guanguans/package-skeleton/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/package-skeleton)
[![Latest Stable Version](https://poser.pugx.org/guanguans/package-skeleton/v)](https://packagist.org/packages/guanguans/package-skeleton)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/package-skeleton)
[![Total Downloads](https://poser.pugx.org/guanguans/package-skeleton/downloads)](https://packagist.org/packages/guanguans/package-skeleton)
[![License](https://poser.pugx.org/guanguans/package-skeleton/license)](https://packagist.org/packages/guanguans/package-skeleton)

## Feature

* ...

## Requirement

* PHP >= 8.0

## Installation

```bash
composer require guanguans/package-skeleton --ansi -v
```

## Usage

1. execute `$ git clone https://github.com/guanguans/package-skeleton.git`
2. replace `guanguans/package-skeleton` -> `vendorName/package-name`
3. replace `Guanguans\\PackageSkeleton` -> `VendorName\\PackageName`
4. replace `Guanguans\PackageSkeleton` -> `VendorName\PackageName`
5. replace `GuanguansPackageSkeletonUpdateHelper` -> `VendorNamePackageNameUpdateHelper`
6. replace `package-skeleton` -> `your repository name`
7. replace `ityaozm@gmail.com` -> `your email`
8. execute `$ composer install && composer dumpautoload`  
9. execute `$ rm .git/ && git init && git add . && git commit -m 'Build the basic skeleton'`

## Testing

```bash
composer test
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
