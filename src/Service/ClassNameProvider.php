<?php

namespace Etudor\ViewableBundle\Service;

use ReflectionClass;
use function str_replace;

class ClassNameProvider
{
    /**
     * @param object $object
     * @return string
     */
    public function get($object): string
    {
        if (is_array($object)) {
            $e = new \Exception();
        }

        $name = (new ReflectionClass($object))->getName();

        // protect against proxy classes created by symfony
        $name = str_replace('Proxies\\__CG__\\', '', $name);

        return $name;
    }
}
