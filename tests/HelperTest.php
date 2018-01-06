<?php
declare(strict_types=1);

class HelperTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @test
     */
    public function isStringStartWithPositive()
    {
        $this->assertTrue(Helper::isStringStartWith('origin/hotfix-test', 'origin/hotfix'));
    }

    /**
     * @test
     */
    public function isStringStartWithNegative()
    {
        $this->assertFalse(Helper::isStringStartWith('origin/test', 'origin/hotfix'));
    }

    /**
     * @test
     */
    public function getDaysDiffWithNow()
    {
        $this->assertEquals(Helper::getDaysDiff(new DateTime()), 0);
    }

    /**
     * @test
     */
    public function getDaysDiffWithYesterday()
    {
        $this->assertEquals(Helper::getDaysDiff(new DateTime('yesterday')), 1);
    }

    /**
     * @test
     */
    public function getDaysDiffWithFiveDays()
    {
        $this->assertEquals(Helper::getDaysDiff(new DateTime('-5 days')), 5);
    }
}
