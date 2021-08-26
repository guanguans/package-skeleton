# package-skeleton

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> A PHP package template repository. - 一个 PHP 软件包模板存储库。

[![tests](https://github.com/guanguans/package-skeleton/workflows/tests/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![check & fix styling](https://github.com/guanguans/package-skeleton/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![codecov](https://codecov.io/gh/guanguans/package-skeleton/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/package-skeleton)
[![Latest Stable Version](https://poser.pugx.org/guanguans/package-skeleton/v)](//packagist.org/packages/guanguans/package-skeleton)
[![Total Downloads](https://poser.pugx.org/guanguans/package-skeleton/downloads)](//packagist.org/packages/guanguans/package-skeleton)
[![License](https://poser.pugx.org/guanguans/package-skeleton/license)](//packagist.org/packages/guanguans/package-skeleton)

## Features

* Integrated [brainmaestro/composer-git-hooks](https://github.com/BrainMaestro/composer-git-hooks) - Git hooks
* Integrated [dms/phpunit-arraysubset-asserts](https://github.com/rdohms/phpunit-arraysubset-asserts) - Unit test assistant package
* Integrated [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) - Unit test
* Integrated [bovigo/vfsStream](https://github.com/bovigo/vfsStream) - Unit test assistant package
* Integrated [mockery/mockery](https://github.com/mockery/mockery) - Mock
* Integrated [Nyholm/NSA](https://github.com/Nyholm/NSA) - Unit test assistant package
* Integrated [phpbench/phpbench](https://github.com/phpbench/phpbench) - Benchmarks  
* Integrated [FriendsOfPHP/PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) - Coding standard check
* Integrated [overtrue/phplint](https://github.com/overtrue/phplint) - Grammar check
* Integrated [vimeo/psalm](https://github.com/vimeo/psalm) - Static check
* Integrated [lint-md/lint-md](https://github.com/lint-md/lint-md) - Markdown grammar check
* With IDE helper file
* With common badge icons
* With Chinese and English `README.md` file

## Requirement

* PHP >= 7.2

## Installation

```bash
$ composer require guanguans/package-skeleton --prefer-dist -vvv
```

## Usage

1. execute `$ git clone https://github.com/guanguans/package-skeleton.git`
2. replace `guanguans/package-skeleton` -> `vendorName/package-name`
3. replace `Guanguans\\PackageSkeleton` -> `VendorName\\PackageName`
4. replace `Guanguans\PackageSkeleton` -> `VendorName\PackageName`
5. replace `ityaozm@gmail.com` -> `your email`
6. execute `$ composer install && composer dumpautoload`  
7. execute `$ rm .git/`
8. execute `$ git init && git add . && git commit -m 'Build the basic skeleton'`

## Testing

```bash
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
