#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

require __DIR__.'/../vendor/autoload.php';

collect([
    __DIR__.'/../composer.json',
    __DIR__.'/../vendor-bin/laravel/composer.json',
    __DIR__.'/../vendor-bin/yii2/composer.json',
])
    ->map(static fn ($composerFile): string => realpath($composerFile))
    ->each(static function ($composerFile): void {
        collect(json_decode(file_get_contents($composerFile), true, 512, JSON_THROW_ON_ERROR))
            ->only(['require', 'require-dev'])
            ->each(static function ($packagist, $env) use ($composerFile): void {
                $symfonyStyle = new SymfonyStyle(new ArgvInput(), new ConsoleOutput());
                $symfonyStyle->note("The composer file($composerFile) $env updating...");

                $packagist = array_filter(
                    $packagist,
                    static fn ($version, $package) => ! in_array(
                        $package,
                        [
                            'php',
                            'elasticquent/elasticquent',
                        ],
                        true
                    ) && '*' !== $version,
                    ARRAY_FILTER_USE_BOTH
                );
                if (empty($package)) {
                    $symfonyStyle->note("The composer file($composerFile) $env nothing to update.");

                    return;
                }

                $packagist = array_map(static fn ($package) => "$package:'*'", array_keys($packagist));
                $hydratedPackagist = implode(' ', $packagist);

                $command = "COMPOSER_MEMORY_LIMIT=-1 composer require $hydratedPackagist -W --ansi -v";
                'require-dev' === $env && $command .= ' --dev';

                $symfonyStyle->note($command);
                Process::fromShellCommandline(
                    $command,
                    dirname($composerFile),
                    ['COMPOSER_MEMORY_LIMIT' => -1]
                )->mustRun(static function ($type, $buffer) use ($symfonyStyle): void {
                    $symfonyStyle->write($buffer);
                });

                $symfonyStyle->note("The composer file($composerFile) $env updated.");
            });
    });
