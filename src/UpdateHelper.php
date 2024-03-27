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

namespace Guanguans\PackageSkeleton;

use UpdateHelper\UpdateHelperInterface;

final class UpdateHelper implements UpdateHelperInterface
{
    public function check(\UpdateHelper\UpdateHelper $updateHelper): void
    {
        $updateHelper->write('Package update checking...');
        $updateHelper->write('Package update checking done.');
    }
}
