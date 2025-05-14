# package-skeleton

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [!NOTE]
> 一个 PHP 软件包模板存储库。- A PHP package template repository。

[![tests](https://github.com/guanguans/package-skeleton/workflows/tests/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![check & fix styling](https://github.com/guanguans/package-skeleton/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions)
[![psalm](https://github.com/guanguans/package-skeleton/actions/workflows/psalm.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions/workflows/psalm.yml)
[![rector](https://github.com/guanguans/package-skeleton/actions/workflows/rector.yml/badge.svg)](https://github.com/guanguans/package-skeleton/actions/workflows/rector.yml)
[![codecov](https://codecov.io/gh/guanguans/package-skeleton/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/package-skeleton)
[![Latest Stable Version](https://poser.pugx.org/guanguans/package-skeleton/v)](https://packagist.org/packages/guanguans/package-skeleton)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/package-skeleton)
![GitHub repo size](https://img.shields.io/github/repo-size/guanguans/package-skeleton)
[![Total Downloads](https://poser.pugx.org/guanguans/package-skeleton/downloads)](https://packagist.org/packages/guanguans/package-skeleton)
[![License](https://poser.pugx.org/guanguans/package-skeleton/license)](https://packagist.org/packages/guanguans/package-skeleton)

## 功能

* ...

## 环境要求

* PHP >= 8.0

## 安装

```bash
composer require guanguans/package-skeleton --ansi -v
```

## 使用

1. 执行 `$ git clone https://github.com/guanguans/package-skeleton.git`
2. 替换 `guanguans/package-skeleton` -> `vendorName/package-name`
3. 替换 `Guanguans\\PackageSkeleton` -> `VendorName\\PackageName`
4. 替换 `Guanguans\PackageSkeleton` -> `VendorName\PackageName`
5. 替换 `GuanguansPackageSkeletonUpdateHelper` -> `VendorNamePackageNameUpdateHelper`
6. 替换 `package-skeleton` -> `your repository name`
7. 替换 `ityaozm@gmail.com` -> `your email`
8. 执行 `$ composer install && composer dumpautoload`
9. 执行 `$ rm .git/ && git init && git add . && git commit -m 'Build the basic skeleton'`

## 测试

```bash
composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证 (MIT)。有关更多信息，请参见[协议文件](LICENSE)。
