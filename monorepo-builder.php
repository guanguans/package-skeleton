<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJsonSection;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (MBConfig $mbConfig): void {
    // // where are the packages located?
    // $mbConfig->packageDirectories([__DIR__.'/packages']);
    //
    // // how to skip packages in loaded directories?
    // $mbConfig->packageDirectoriesExcludes([__DIR__.'/packages/secret-package']);
    //
    // // default: "<major>.<minor>-dev"
    // $mbConfig->packageAliasFormat('<major>.<minor>.x-dev');
    //
    // // "merge" command related
    // // what extra parts to add after merge?
    // $mbConfig->dataToAppend([
    //     ComposerJsonSection::CONFIG => [
    //         'apcu-autoloader' => true,
    //         'classmap-authoritative' => false,
    //         'optimize-autoloader' => true,
    //         'preferred-install' => 'dist',
    //         'sort-packages' => true,
    //     ],
    // ]);
    //
    // $mbConfig->dataToRemove([
    //     ComposerJsonSection::REQUIRE => [
    //         // the line is removed by key, so version is irrelevant, thus *
    //         'phpunit/phpunit' => '*',
    //     ],
    //     ComposerJsonSection::REPOSITORIES => [
    //         // this will remove all repositories
    //         Option::REMOVE_COMPLETELY,
    //     ],
    // ]);

    /**
     * release workers - in order to execute
     *
     * @see https://github.com/symplify/monorepo-builder#6-release-flow
     */
    $mbConfig->workers([
        // UpdateReplaceReleaseWorker::class,
        // SetCurrentMutualDependenciesReleaseWorker::class,
        AddTagToChangelogReleaseWorker::class,
        TagVersionReleaseWorker::class,
        PushTagReleaseWorker::class,
        // SetNextMutualDependenciesReleaseWorker::class,
        UpdateBranchAliasReleaseWorker::class,
        PushNextDevReleaseWorker::class,
    ]);
};
