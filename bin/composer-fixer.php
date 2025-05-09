#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Illuminate\Support\Stringable;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;

require __DIR__.'/../vendor/autoload.php';

collect(
    Finder::create()
        ->in([
            __DIR__.'/../',
            __DIR__.'/../vendor-bin/*/',
        ])
        ->exclude('vendor')
        ->name('composer.json')
        ->depth(0)
        ->files()
)
    ->each(static function (SplFileInfo $splFileInfo): void {
        /** @noinspection PhpUnhandledExceptionInspection */
        collect(json_decode($splFileInfo->getContents(), true, 512, \JSON_THROW_ON_ERROR))
            ->only(['require', 'require-dev'])
            ->each(static function ($packagist, $env) use ($splFileInfo): void {
                $symfonyStyle = new SymfonyStyle(new ArgvInput, new ConsoleOutput);
                $symfonyStyle->note(sprintf('The composer file(%s) %s updating...', $splFileInfo->getRealPath(), $env));

                $hydratedPackagist = collect($packagist)
                    ->filter(static fn ($version, $package) => !\in_array(
                        $version,
                        ['*', 'dev-main', 'dev-master'],
                        true
                    ) && !\in_array(
                        $package,
                        ['php', 'elasticquent/elasticquent'],
                        true
                    ))
                    ->map(static fn ($version, $package) => "$package:'*'")
                    ->implode(' ');

                if (empty($hydratedPackagist)) {
                    $symfonyStyle->note(sprintf('The composer file(%s) %s nothing to update.', $splFileInfo->getRealPath(), $env));
                    $symfonyStyle->newLine();

                    return;
                }

                /** @noinspection ToStringSimplificationInspection */
                $command = str("COMPOSER_MEMORY_LIMIT=-1 composer require $hydratedPackagist -W --ansi -v")
                    ->when('require-dev' === $env, static fn (Stringable $command) => $command->append(' --dev'))
                    ->__toString();
                $symfonyStyle->note($command);
                Process::fromShellCommandline($command, $splFileInfo->getPath(), ['COMPOSER_MEMORY_LIMIT' => -1])
                    ->mustRun(static function ($type, $buffer) use ($symfonyStyle): void {
                        $symfonyStyle->write($buffer);
                    });

                $symfonyStyle->note(sprintf('The composer file(%s) %s updated.', $splFileInfo->getRealPath(), $env));
                $symfonyStyle->newLine();
            });
    });
