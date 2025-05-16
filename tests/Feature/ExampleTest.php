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

namespace Guanguans\PackageSkeletonTests\Feature;

use Guanguans\PackageSkeleton\PackageSkeleton;
use Guanguans\PackageSkeletonTests\LaravelTestCase;

final class ExampleTest extends LaravelTestCase
{
    public function testItIsTestingExample(): void
    {
        // self::markTestIncomplete('This test has not been implemented yet.');
        // self::markTestSkipped('The PostgreSQL extension is not available');
        self::assertTrue((new PackageSkeleton)->testing());
    }
}
