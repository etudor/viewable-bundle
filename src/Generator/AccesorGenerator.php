<?php

namespace Etudor\ViewableBundle\Generator;

use Etudor\ViewableBundle\Accessor\ViewableAccessorInterface;
use Etudor\ViewableBundle\Exception\NoAccessorTemplateException;
use Etudor\ViewableBundle\Service\ClassNameProvider;
use Twig_Environment;
use Twig_Error;

class AccesorGenerator implements GeneratorInterface
{
    const METHOD_PREFIX = 'get';

    /**
     * @var ViewableAccessorInterface[]
     */
    private $accessors;

    /**
     * @var Twig_Environment
     */
    private $twigEnvironment;

    /**
     * @var ClassNameProvider
     */
    private $classNameProvider;

    /**
     * @param ClassNameProvider $classNameProvider
     * @param Twig_Environment  $twigEnvironment
     */
    public function __construct(ClassNameProvider $classNameProvider, Twig_Environment $twigEnvironment)
    {
        $this->classNameProvider = $classNameProvider;
        $this->twigEnvironment   = $twigEnvironment;
    }

    /**
     * @param ViewableAccessorInterface $accessor
     */
    public function registerAccessor(ViewableAccessorInterface $accessor)
    {
        $this->accessors[] = $accessor;
    }

    /**
     * @inheritdoc
     */
    public function supports($object)
    {
        foreach($this->accessors as $accessor) {
            if ($accessor->supports($object)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function generate($object, $viewName, $params)
    {
        foreach ($this->accessors as $accessor) {
            $viewTemplate = $this->classNameProvider->get($object) . ':' . $viewName . '_' . $accessor->getAccessor($object);

            try {
                return $this->twigEnvironment->render(
                    $viewTemplate,
                    array_merge($params, [
                                           'this' => $object,
                                       ]
                    )
                );
            } catch (Twig_Error $e) {
                // view does not exists
                return null;
            }
        }

        throw new NoAccessorTemplateException(
            sprintf("The object %s does not match any view accessors for view %s.", $this->classNameProvider->get($object), $viewName)
        );
    }
}
