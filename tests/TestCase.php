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
use phpmock\phpunit\PHPMock;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @coversNothing
 *
 * @small
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    use ArraySubsetAsserts;
    use Faker;
    use MatchesSnapshots;
    use PHPMock;

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        // \DG\BypassFinals::enable();
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->finish();
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    private function finish(): void
    {
        // call more tear down methods
    }
}
