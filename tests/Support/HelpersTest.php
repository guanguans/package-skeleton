<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection PhpInternalEntityUsedInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Pest\Expectation;
use function Guanguans\PackageSkeleton\Support\env_explode;

it('can explode env', function (): void {
    expect([
        env_explode('ENV_EXPLODE_STRING'),
        env_explode('ENV_EXPLODE_EMPTY'),
        env_explode('ENV_EXPLODE_NOT_EXIST'),
        // env_explode('ENV_EXPLODE_FALSE'),
        // env_explode('ENV_EXPLODE_NULL'),
        // env_explode('ENV_EXPLODE_TRUE'),
    ])->sequence(
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeTruthy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeArray()->toBeFalsy(),
        static fn (Expectation $expectation): Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeFalse(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeNull(),
        // static fn (Pest\Expectation $expectation): Pest\Expectation => $expectation->toBeTrue(),
    );
})->group(__DIR__, __FILE__)->skip();
