<?php

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

it('to be string', function ($movie): void {
    expect($movie)->toBeString();
})->group(__DIR__, __FILE__)->with('movies');
