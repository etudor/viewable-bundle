<?php

namespace Etudor\ViewableBundle\Service;

interface GeneratorInterface
{
    /**
     * @param        $object
     * @param string $view
     * @param array  $params
     *
     * @return string
     */
    public function generate($object, $view = 'base', $params = []);
}
