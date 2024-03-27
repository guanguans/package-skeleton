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

namespace Guanguans\PackageSkeleton\Tests\Benchmark;

use Guanguans\PackageSkeleton\PackageSkeleton;

/**
 * @beforeMethods({"setUp"})
 *
 * @warmup(2)
 *
 * @revs(1000)
 *
 * @iterations(15)
 */
final class PackageSkeletonBench
{
    private PackageSkeleton $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton;
    }

    public function benchTest(): void
    {
        // $this->packageSkeleton->test();
        PackageSkeleton::test();
    }
}
