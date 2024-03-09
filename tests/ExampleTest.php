<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeletonTests;

it('to be string.', function ($movie): void {
    expect($movie)->toBeString();
})->group(__DIR__, __FILE__)->with('movies');

it('is is snapshot.', function ($movie): void {
    $this->assertMatchesSnapshot($movie);
})->group(__DIR__, __FILE__)->with('movies');
