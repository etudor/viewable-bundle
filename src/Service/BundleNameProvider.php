<?php

namespace Etudor\ViewableBundle\Service;

use function dump;

class BundleNameProvider
{
    /**
     * @var ClassNameProvider
     */
    private $classNameProvider;

    public function __construct(ClassNameProvider $classNameProvider)
    {
        $this->classNameProvider = $classNameProvider;
    }

    /**
     * @param object $entity
     * @return string
     */
    public function get($entity): string
    {
        dump($this->classNameProvider->get($entity));

        $name = str_replace('Entity\\', '', $this->classNameProvider->get($entity));

        return str_replace('\\', ':', $name);
    }
}
