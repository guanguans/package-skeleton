<?php

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use UpdateHelper\UpdateHelper;
use UpdateHelper\UpdateHelperInterface;

class GuanguansPackageSkeletonUpdateHelper implements UpdateHelperInterface
{
    public function check(UpdateHelper $helper)
    {
        $helper->write('The guanguans/laravel-proxy-manager update checking...');
        $helper->write('The guanguans/laravel-proxy-manager update checking done.');
    }
}
