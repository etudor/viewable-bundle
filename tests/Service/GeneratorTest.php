<?php

namespace Etudor\ViewableBundle\Tests\Service;

use Etudor\ViewableBundle\Generator\AccesorGenerator;
use Etudor\ViewableBundle\Generator\ArrayGenerator;
use Etudor\ViewableBundle\Generator\DefaultGenerator;
use Etudor\ViewableBundle\Service\Generator;
use PHPUnit_Framework_TestCase;
use Twig_Environment;

class GeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetSimpleView()
    {
        $expectedView = 'asd';
        $generator = new Generator();

        $accessorGenerator = $this->getMockBuilder(AccesorGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $arrayGenerator = $this->getMockBuilder(ArrayGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $defaultGenerator = $this->getMockBuilder(DefaultGenerator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $defaultGenerator->method('supports')
            ->willReturn(true);

        $defaultGenerator->expects($this->once())
            ->method('generate')
            ->willReturn('asd');

        $generator->registerGenerator($accessorGenerator);
        $generator->registerGenerator($arrayGenerator);
        $generator->registerGenerator($defaultGenerator);

        $object = new \stdClass();
        $view = $generator->generate($object);

        $this->assertEquals($expectedView, $view);
    }
}
