<?php

namespace Etudor\ViewableBundle\Service;

use ReflectionClass;

class ClassNameProvider
{
    /**
     * @param object $object
     * @return string
     */
    public function get($object)
    {
        if (is_array($object)) {
            $e = new \Exception();
            dump($e->getTrace());
            die;
        }
        return (new ReflectionClass($object))->getShortName();
    }
}
