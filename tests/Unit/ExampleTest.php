<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Guanguans\PackageSkeleton\PackageSkeleton;

it('is movie', function (string $movie): void {
    expect($movie)->toBeString();
})->group(__DIR__, __FILE__)->with('movies');

it('is snapshot movie', function ($movie): void {
    expect($movie)->toMatchSnapshot();
})->group(__DIR__, __FILE__)->with('movies');

it('is testing example', function (): void {
    expect(new PackageSkeleton)->testing()->toBeTrue();
})->group(__DIR__, __FILE__);
