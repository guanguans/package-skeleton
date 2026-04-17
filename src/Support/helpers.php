<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

namespace Guanguans\PackageSkeleton\Support;

if (!\function_exists('Guanguans\PackageSkeleton\Support\env_explode')) {
    /**
     * @param non-empty-string $delimiter
     *
     * @noinspection LaravelFunctionsInspection
     */
    function env_explode(string $key, mixed $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX): mixed
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}
