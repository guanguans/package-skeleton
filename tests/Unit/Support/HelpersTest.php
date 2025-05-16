<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection LaravelFunctionsInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Illuminate\Support\Str;
use function Guanguans\PackageSkeleton\Support\classes;

it('can get classes', function (): void {
    expect(
        classes(fn (string $file, string $class): bool => Str::of($class)->startsWith('Rector'))
    )->toBeCollection();
})->group(__DIR__, __FILE__);
