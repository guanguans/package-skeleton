<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

namespace Guanguans\PackageSkeletonTests;

use Guanguans\PackageSkeleton\PackageSkeleton;

/**
 * @internal
 *
 * @coversNothing
 *
 * @small
 */
final class PackageSkeletonLaravelTest extends LaravelTestCase
{
    public function testTest(): void
    {
        self::assertTrue(PackageSkeleton::test());
        self::markTestIncomplete('This test has not been implemented yet.');
        self::markTestSkipped('The PostgreSQL extension is not available');
    }
}
