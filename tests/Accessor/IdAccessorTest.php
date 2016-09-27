<?php

namespace Etudor\ViewableBundle\Tests\Accessor;

use Etudor\ViewableBundle\Accessor\IdAccessor;
use PHPUnit_Framework_TestCase;
use stdClass;

class IdAccessorTest extends PHPUnit_Framework_TestCase
{
    public function testItWorks()
    {
        $this->assertTrue(true);
    }

    public function getAccessor()
    {
        $testId = 12;
        $accessor = new IdAccessor();

        $mockObject = $this->getMockBuilder(stdClass::class)->getMock();
        $mockObject->method('getId')->willReturn($testId);

        $accessorId = $accessor->getAccessor($mockObject);

        $this->assertEquals($accessorId, $testId);
    }
}
