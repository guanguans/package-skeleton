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

namespace Guanguans\PackageSkeletonTests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @internal
 *
 * @coversNothing
 *
 * @small
 */
final class LaravelTestCase extends TestCase
{
    use ArraySubsetAsserts;
    use MatchesSnapshots;

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void {}

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass(): void {}

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // \DG\BypassFinals::enable();

        Factory::guessFactoryNamesUsing(
            static fn ($modelName): string => 'Guanguans\\PackageSkeleton\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $this->finish();
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish(): void
    {
        // call more tear down methods
    }

    protected function getPackageProviders($app)
    {
        return [
            // SkeletonServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        // $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        // $migration->up();
    }
}
