<?php

namespace Etudor\ViewableBundle\Generator;

use Doctrine\Common\Collections\Collection;
use Etudor\ViewableBundle\Service\BundleNameProvider;
use Etudor\ViewableBundle\Service\ClassNameProvider;
use Twig_Environment;

class ArrayGenerator implements GeneratorInterface
{
    const DEFAULT_OBJECT_COLLECTION = 'many';

    /**
     * @var ClassNameProvider
     */
    private $classNameProvider;

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var string
     */
    private $collectionKey = self::DEFAULT_OBJECT_COLLECTION;

    /**
     * @param ClassNameProvider $classNameProvider
     * @param Twig_Environment  $twigEnvironment
     * @param string            $collectionKey
     */
    public function __construct(BundleNameProvider $classNameProvider, Twig_Environment $twigEnvironment, $collectionKey = null)
    {
        $this->classNameProvider = $classNameProvider;
        $this->twigEnvironment   = $twigEnvironment;

        if (null !== $collectionKey) {
            $this->collectionKey     = $collectionKey;
        }
    }

    /**
     * @inheritdoc
     */
    public function supports($object): bool
    {
        return is_array($object) || $object instanceof Collection;
    }

    /**
     * @inheritdoc
     */
    public function generate($objectArray, $viewName, $params): string
    {
        if (empty($objectArray)) {
            return '';
        }

        $firstItem = $objectArray[0];

        $singleTemplate = $this->classNameProvider->get($firstItem) . ':Listing/' . $viewName . '.html.twig';

        return $this->twigEnvironment->render(
            $singleTemplate,
            array_merge($params, [
                                   $this->collectionKey => $objectArray,
                               ]
            )
        );
    }
}
