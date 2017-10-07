<?php

namespace Etudor\ViewableBundle\Generator;

interface GeneratorInterface
{
    /**
     * @param object $object
     * @return bool
     */
    public function supports($object);

    /**
     * @param object[]|object $object
     * @param string          $viewName
     * @param mixed           $params
     * @return string
     */
    public function generate($object, $viewName, $params);
}
