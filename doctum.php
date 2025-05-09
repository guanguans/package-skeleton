<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/package-skeleton
 */

use Doctum\Doctum;
use Doctum\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('tests')
    ->in($dir = __DIR__.'/src');

$versions = GitVersionCollection::create($dir)
    // ->addFromTags('v1.*')
    // ->add('1.x', '1.x branch')
    ->add('main', 'main branch');

return new Doctum(
    $iterator,
    [
        'theme' => 'default',
        'versions' => $versions,
        'title' => 'API',
        // 'favicon' => 'https://www.guanguans.cn/coole/static/favicon.png',
        // 'build_dir' => __DIR__.'/docs/api/%version%',
        // 'cache_dir' => __DIR__.'/build/doctum/api/%version%',
        'build_dir' => __DIR__.'/docs/api/',
        'cache_dir' => __DIR__.'/build/doctum/api/',
        'default_opened_level' => 2,
        'footer_link' => [
            'href' => 'https://github.com/guanguans/package-skeleton',
            'rel' => 'noreferrer noopener',
            'target' => '_blank',
            'before_text' => 'You can edit the configuration',
            'link_text' => 'on this', // Required if the href key is set
            'after_text' => 'repository.',
        ],
    ]
);
