<?php

/*
 * This file is part of the guanguans/di.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Di\Tests;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Tear down the test case.
     */
    public function tearDown()
    {
        $this->finish();
        parent::tearDown();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
    }
}
