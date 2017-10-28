<?php

namespace Etudor\ViewableBundle\Tests\Service;

use Etudor\ViewableBundle\Service\BundleNameProvider;
use Etudor\ViewableBundle\Service\ClassNameProvider;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class BundleNameProviderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getBundleTests
     */
    public function testSimpleBundle($entityName, $expectedViewName)
    {
        /** @var PHPUnit_Framework_MockObject_MockObject|ClassNameProvider $classNameProvider */
        $classNameProvider = $this->getMockBuilder(ClassNameProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $classNameProvider->method('get')
            ->willReturn($entityName);
        $bundleNameProvider = new BundleNameProvider($classNameProvider);

        $viewName = $bundleNameProvider->get(new \stdClass());

        $this->assertEquals($expectedViewName, $viewName);
    }

    public function getBundleTests()
    {
        return [
            ['AppBundle\Entity\Classified', 'AppBundle:Classified'],
            ['AppBundle\Entity\Classified', 'AppBundle:Classified']
        ];
    }
}
