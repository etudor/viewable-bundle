<?php

namespace Etudor\ViewableBundle\Generator;

use Doctrine\Common\Collections\Collection;
use Etudor\ViewableBundle\Service\ClassNameProvider;
use Twig_Environment;

class DefaultGenerator implements GeneratorInterface
{
    const DEFAULT_VIEW = 'base';

    /**
     * @var ClassNameProvider
     */
    private $classNameProvider;

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    public function __construct(ClassNameProvider $classNameProvider, Twig_Environment $twigEnvironment)
    {
        $this->classNameProvider = $classNameProvider;
        $this->twigEnvironment   = $twigEnvironment;
    }

    /**
     * @inheritdoc
     */
    public function supports($object)
    {
        return is_object($object) && $object instanceof Collection === false;
    }

    /**
     * @inheritdoc
     */
    public function generate($object, $viewName, $params)
    {
        $viewTemplate = 'Entity/' . $this->classNameProvider->get($object) . '/' . $viewName . '.html.twig';

        return $this->twigEnvironment->render(
            $viewTemplate,
            array_merge($params, [
                                   'this' => $object,
                               ]
            )
        );
    }
}
