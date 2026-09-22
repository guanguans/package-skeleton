<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpUnusedAliasInspection */
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
use Guanguans\PhpCsFixerCustomFixers\Support\Utils;
use Guanguans\RectorRules\Rector\File\AddNoinspectionDocblockToFileFirstStmtRector;
use Guanguans\RectorRules\Rector\Name\RenameToConventionalCaseNameRector;
use Guanguans\RectorRules\Set\SetList;
use Pest\Rector\Set\PestSetList;
use PhpParser\NodeVisitor\ParentConnectingVisitor;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\Config\RectorConfig;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\Renaming\Rector\FuncCall\RenameFunctionRector;
use Rector\ValueObject\PhpVersion;
use RectorLaravel\Rector\ArrayDimFetch\ArrayToArrGetRector;
use RectorLaravel\Rector\Empty_\EmptyToBlankAndFilledFuncRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\If_\ThrowIfRector;
use RectorLaravel\Rector\MethodCall\ValidationRuleArrayStringValueToArrayRector;
use RectorLaravel\Rector\StaticCall\DispatchToHelperFunctionsRector;
use RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector;

error_reporting(\E_ALL & ~\E_DEPRECATED & ~\E_USER_DEPRECATED);

return RectorConfig::configure()
    ->withPaths([
        // __DIR__.'/config/',
        __DIR__.'/src/',
        __DIR__.'/tests/',
        // __DIR__.'/workbench/',
        ...Utils::defaultRootFiles(),
    ])
    ->withRootFiles()
    ->withSkip(['*/Fixtures/*', __DIR__.'/_ide_helper.php'])
    ->withSkip([
        LogicalToBooleanRector::class,
        NewlineBetweenClassLikeStmtsRector::class,
        PreferPHPUnitThisCallRector::class,
        SplitDoubleAssignRector::class,
    ])
    ->withSkip([
        // ArrayToArrGetRector::class,
        // DispatchToHelperFunctionsRector::class,
        // EmptyToBlankAndFilledFuncRector::class,
        // HelperFuncCallToFacadeClassRector::class,
        // RequestStaticValidateToInjectRector::class,
        // ThrowIfRector::class,
        // ValidationRuleArrayStringValueToArrayRector::class,
    ])
    ->withSkip([
        RenameParamToMatchTypeRector::class => [
            __DIR__.'/tests/Pest.php',
        ],
        SortAssociativeArrayByKeyRector::class => [
            // __DIR__.'/config/',
        ],
    ])
    ->withCache(__DIR__.'/.build/rector/')
    // ->withoutParallel()
    ->withParallel()
    ->withImportNames(importDocBlockNames: false, importShortClasses: false, removeUnusedImports: false)
    // ->withImportNames(true, false, false, false)
    ->reportUnusedSkips()
    ->withFluentCallNewLine()
    ->withTreatClassesAsFinal()
    ->withTypeGuardedClasses([])
    ->withAttributesSets(phpunit: true, all: true)
    ->withComposerBased(phpunit: true, laravel: true)
    ->withPhpVersion(PhpVersion::PHP_85)
    // ->withDowngradeSets(php85: true)
    ->withPhpSets(php85: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        typeDeclarationDocblocks: true,
        privatization: true,
        naming: true,
        // namedArgs: true,
        carbon: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
        phpunitNarrowAsserts: true,
        phpunitMockToStub: true,
    )
    ->withSets([
        SetList::ALL,
        PestSetList::CODING_STYLE,
    ])
    ->withConfiguredRule(AddNoinspectionDocblockToFileFirstStmtRector::class, [
        '*/tests/*' => [
            'AnonymousFunctionStaticInspection',
            'NullPointerExceptionInspection',
            'PhpFieldAssignmentTypeMismatchInspection',
            'PhpPossiblePolymorphicInvocationInspection',
            'PhpUndefinedClassInspection',
            'PhpUnhandledExceptionInspection',
            'PhpVoidFunctionResultUsedInspection',
            // 'SqlResolve',
            'StaticClosureCanBeUsedInspection',
        ],
    ])
    ->registerDecoratingNodeVisitor(ParentConnectingVisitor::class)
    ->withConfiguredRule(RenameToConventionalCaseNameRector::class, ['afterEach', 'beforeEach', 'MIT', 'PDO'])
    ->withConfiguredRule(
        RenameFunctionRector::class,
        collect(['env_explode', 'make'])
            ->mapWithKeys(static fn (string $func): array => [$func => "Guanguans\\PackageSkeleton\\Support\\$func"])
            ->all()
    );
