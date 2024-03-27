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

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Webmozart\Glob\Glob;

return static fn (Configuration $config): Configuration => $config
    ->addNamedFilter(NamedFilter::fromString('symfony/config'))
    ->addPatternFilter(PatternFilter::fromString('/symfony\/.*/'))
    ->setAdditionalFilesFor('icanhazstring/composer-unused', [
        __FILE__,
        ...Glob::glob(__DIR__.'/config/*.php'),
    ]);
