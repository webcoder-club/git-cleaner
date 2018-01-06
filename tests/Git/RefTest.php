<?php
declare(strict_types=1);

namespace Git;

class RefTest extends \PHPUnit\Framework\TestCase
{
    /** @var Ref */
    protected $gitRef;

    protected function setUp()
    {
        $this->gitRef = new Ref(['origin/hotfix-test', '8157cb839b3', '<isomov@avito.ru>', 1513292302]);
    }

    /**
     * @test
     */
    public function stringify()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function getRefName()
    {
        $this->assertEquals('origin/hotfix-test', $this->gitRef->getRefName());
    }

    /**
     * @test
     */
    public function getAuthorEmail()
    {
        $this->assertEquals('isomov@avito.ru', $this->gitRef->getAuthorEmail());
    }

    /**
     * @test
     */
    public function GetCommitterDate()
    {
        $expected = (new \DateTime())->setTimestamp(1513292302);

        $this->assertEquals($expected, $this->gitRef->getCommitterDate());
    }
}
