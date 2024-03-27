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

namespace PHPSTORM_META;

use Illuminate\Bus\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use Illuminate\View\FileViewFinder;
use Psr\Container\ContainerInterface;

/**
 * PhpStorm Meta file, to provide autocomplete information for PhpStorm.
 */
override(new \Illuminate\Contracts\Container\Container, map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override((new Container)->makeWith(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override((new \Illuminate\Contracts\Container\Container)->get(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override((new \Illuminate\Contracts\Container\Container)->make(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override((new \Illuminate\Contracts\Container\Container)->makeWith(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));
override(\App::get(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override(\App::make(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override(\App::makeWith(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override(app(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));
override(resolve(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override((new ContainerInterface)->get(0), map([
    '' => '@',
    Dispatcher::class => Dispatcher::class,
    'db' => DatabaseManager::class,
    'view.finder' => FileViewFinder::class,
]));

override(Arr::add(0), type(0));
override(optional(0), type(0));
