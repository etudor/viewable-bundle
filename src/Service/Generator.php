<?php

namespace Etudor\ViewableBundle\Service;

use Doctrine\Common\Collections\Collection;
use Etudor\ViewableBundle\Accessor\ViewableAccessorInterface;
use Etudor\ViewableBundle\Exception\NoAccessorTemplateException;
use Etudor\ViewableBundle\Exception\ViewableException;
use Etudor\ViewableBundle\Generator\GeneratorInterface;
use InvalidArgumentException;
use ReflectionClass;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Twig_Environment;
use Twig_Error;
use Twig_Error_Loader;

class Generator
{
    const DEFAULT_OBJECT_NAME = 'this';

    /**
     * @var GeneratorInterface[]
     */
    private $generators = [];

    /**
     * @var string
     */
    private $defaultViewName = 'base';

    /**
     * @var string
     */
    protected $objectNameSingle = self::DEFAULT_OBJECT_NAME;

    /**
     * @param GeneratorInterface $generator
     */
    public function registerGenerator(GeneratorInterface $generator)
    {
        $this->generators[] = $generator;
    }

    /**
     * @param        $object
     * @param string $view
     * @param []     $params
     *
     * @return string
     *
     * @throws ViewableException
     */
    public function generate($object, $view = null, $params = []): string
    {
        if (null === $view || $view == '') {
            $view = $this->defaultViewName;
        }

        foreach ($this->generators as $generator) {
            if ($generator->supports($object)) {
                return $generator->generate($object, $view, $params);
            }
        }

        // todo throw exception here
        throw new ViewableException("no generator is supported.");
    }
}
