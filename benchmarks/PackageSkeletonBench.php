<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

namespace Guanguans\PackageSkeleton\Tests\Benchmark;

use Guanguans\PackageSkeleton\PackageSkeleton;
use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Revs;

#[BeforeMethods('setUp')]
#[Revs(10000)]
final class PackageSkeletonBench
{
    private PackageSkeleton $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton;
    }

    public function benchTesting(): void
    {
        $this->packageSkeleton->testing();
    }
}
