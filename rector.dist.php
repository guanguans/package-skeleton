<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Ergebnis\Rector\Rules\Expressions\Arrays\SortAssociativeArrayByKeyRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\AddSeeTestAnnotationRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\ValueObject\PhpVersion;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/benchmarks/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        ...glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE),
    ])
    ->withRootFiles()
    // ->withSkipPath(__DIR__.'/tests.php')
    ->withSkip([
        '**/__snapshots__/*',
        '**/Fixtures/*',
        __DIR__.'/tests.php',
        // __FILE__,
    ])
    ->withAutoloadPaths([
        new ReflectionClass(ReleaseWorkerInterface::class)->getFileName(),
    ])
    ->withBootstrapFiles([
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/autoload.php',
        // __DIR__.'/vendor/symplify/monorepo-builder/vendor/scoper-autoload.php',
    ])
    ->withCache(__DIR__.'/.build/rector/')
    ->withParallel()
    // ->withoutParallel()
    // ->withImportNames(importNames: false)
    ->withImportNames(importDocBlockNames: false, importShortClasses: false)
    ->withFluentCallNewLine()
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true)
    ->withPhpVersion(PhpVersion::PHP_85)
    // ->withDowngradeSets(php85: true)
    ->withPhpSets(php85: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        // carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withSets([
        PHPUnitSetList::PHPUNIT_90,
    ])
    ->withRules([
        AddSeeTestAnnotationRector::class,
        ArraySpreadInsteadOfArrayMergeRector::class,
        JsonThrowOnErrorRector::class,
        SortAssociativeArrayByKeyRector::class,
        StaticArrowFunctionRector::class,
        StaticClosureRector::class,
    ])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        [
            'Pest\Faker\fake' => 'fake',
            'Pest\Faker\faker' => 'faker',
            'faker' => 'fake',
            'test' => 'it',
        ] + array_reduce(
            [
                'classes',
            ],
            static function (array $carry, string $func): array {
                /** @see https://github.com/laravel/framework/blob/11.x/src/Illuminate/Support/functions.php */
                $carry[$func] = "Guanguans\\PackageSkeleton\\Support\\$func";

                return $carry;
            },
            []
        )
    )
    ->withSkip([
        DisallowedEmptyRuleFixerRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        LogicalToBooleanRector::class,
        NewlineAfterStatementRector::class,
        PreferPHPUnitThisCallRector::class,
        ReturnBinaryOrToEarlyReturnRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ])
    ->withSkip([
        JsonThrowOnErrorRector::class => [
            __DIR__.'/tests/Pest.php',
        ],
        RenameParamToMatchTypeRector::class => [
            __DIR__.'/tests/Pest.php',
        ],
        SortAssociativeArrayByKeyRector::class => [
            __DIR__.'/benchmarks',
            __DIR__.'/src',
            __DIR__.'/tests',
            __DIR__.'/doctum.php',
        ],
        StaticArrowFunctionRector::class => $staticClosureSkipPaths = [
            __DIR__.'/tests',
        ],
        StaticClosureRector::class => $staticClosureSkipPaths,
    ]);
