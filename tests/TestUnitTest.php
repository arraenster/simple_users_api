<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Simple class to test PHPUnit
 */
class TestUnitTest extends TestCase
{
    /**
     * Test test case
     */
    public function testTrue()
    {
        $true = true;

        $this->assertEquals(true, $true);
    }

    /**
     * Test test case
     */
    public function testNotTrue()
    {
        $true = false;

        $this->assertNotEquals(true, $true);
    }
}
