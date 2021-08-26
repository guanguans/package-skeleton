<?php

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeleton\Tests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use InterNations\Component\HttpMock\PHPUnit\HttpMockTrait;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use ArraySubsetAsserts;
    use HttpMockTrait;

    public static function setUpBeforeClass(): void
    {
        // static::setUpHttpMockBeforeClass('8088', 'localhost');
    }

    public static function tearDownAfterClass(): void
    {
        // static::tearDownHttpMockAfterClass();
    }

    public function setUp(): void
    {
        // $this->setUpHttpMock();
    }

    /**
     * Tear down the test case.
     */
    public function tearDown(): void
    {
        $this->finish();
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
        // $this->tearDownHttpMock();
    }
}
