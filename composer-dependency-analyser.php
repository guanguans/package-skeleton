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

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration;

$classNameRegex = '[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*'; // https://www.php.net/manual/en/language.oop5.basic.php
$dicFileContents = file_get_contents(__FILE__);
preg_match_all(
    "~$classNameRegex(?:\\\\$classNameRegex)+~", // at least one backslash
    $dicFileContents,
    $matches
); // or parse the yaml properly

return $config
    // disable scanning autoload & autoload-dev paths from composer.json
    // with such option, you should add custom paths by addPathToScan() or addPathsToScan()
    ->disableComposerAutoloadPathScan()

    // report unused dependencies even for dev packages
    // dev packages are often used only in CI, so this is not enabled by default
    // but you may want to ignore those packages manually to be sure
    ->enableAnalysisOfUnusedDevDependencies()

    // do not report ignores that never matched any error
    ->disableReportingUnmatchedIgnores()

    // globally disable specific error type
    ->ignoreErrors([ErrorType::DEV_DEPENDENCY_IN_PROD])

    // overwrite file extensions to scan, defaults to 'php'
    // applies only to directory scanning, not directly listed files
    ->setFileExtensions(['php'])

    // add extra path to scan
    // for multiple paths at once, use addPathsToScan()
    ->addPathToScan(__DIR__.'/build', false)

    // exclude path from scanning
    // for multiple paths at once, use addPathsToExclude()
    ->addPathToExclude(__DIR__.'/tests/fixtures')

    // ignore errors on specific paths
    // this can be handy when DIC container file was passed as extra path, but you want to ignore shadow dependencies there
    // for multiple paths at once, use ignoreErrorsOnPaths()
    ->ignoreErrorsOnPath(__DIR__.'/tests/TestCase.php', [ErrorType::SHADOW_DEPENDENCY])

    // ignore errors on specific packages
    // you might have various reasons to ignore certain errors
    // e.g. polyfills are often used in libraries, but those are obviously unused when running with latest PHP
    // for multiple packages at once, use ignoreErrorsOnPackages()
    ->ignoreErrorsOnPackage('symfony/polyfill-php73', [ErrorType::UNUSED_DEPENDENCY])

    // ignore errors on specific packages and paths
    // for multiple, use ignoreErrorsOnPackagesAndPaths() or ignoreErrorsOnPackageAndPaths()
    // ->ignoreErrorsOnPackageAndPath('symfony/console', __DIR__.'/src/OptionalCommand.php', [ErrorType::SHADOW_DEPENDENCY])

    // allow using classes not present in composer's autoloader
    // e.g. a library may conditionally support some feature only when Memcached is available
    ->ignoreUnknownClasses(['Memcached'])

    // allow using classes not present in composer's autoloader by regex
    // e.g. when you want to ignore whole namespace of classes
    ->ignoreUnknownClassesRegex('~^PHPStan\\.*?~');

// force certain classes to be treated as used
// handy when dealing with dependencies in non-php files (e.g. DIC config), see example below
// beware that those are not validated and do not even trigger unknown class error
// ->addForceUsedSymbols($matches[1])
