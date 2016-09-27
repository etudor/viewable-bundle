<?php

namespace Etudor\ViewableBundle\Tests\Service;

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

        $twig = $this->getMockBuilder(Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $generator = new Generator($twig);

        $object = new \stdClass();

        $twig->expects($this->once())
            ->method('render')
            ->with(
                'Entity/stdClass/base.html.twig',
                [
                    Generator::DEFAULT_OBJECT_NAME => $object
                ]
            )
            ->willReturn($expectedView);

        $view = $generator->generate($object);

        $this->assertEquals($expectedView, $view);
    }
}
