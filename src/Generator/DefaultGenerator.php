<?php

namespace Etudor\ViewableBundle\Generator;

use Doctrine\Common\Collections\Collection;
use Etudor\ViewableBundle\Service\BundleNameProvider;
use Etudor\ViewableBundle\Service\ClassNameProvider;
use Twig_Environment;
use function var_dump;

class DefaultGenerator implements GeneratorInterface
{
    const DEFAULT_VIEW = 'base';

    /**
     * @var BundleNameProvider
     */
    private $bundleNameProvider;

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    public function __construct(BundleNameProvider $bundleNameProvider, Twig_Environment $twigEnvironment)
    {
        $this->bundleNameProvider = $bundleNameProvider;
        $this->twigEnvironment    = $twigEnvironment;
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
        $viewTemplate = $this->bundleNameProvider->get($object) . ':' . $viewName . '.html.twig';

        return $this->twigEnvironment->render(
            $viewTemplate,
            array_merge($params, [
                                   'this' => $object,
                               ]
            )
        );
    }
}
