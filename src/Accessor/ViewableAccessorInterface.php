<?php

namespace Etudor\ViewableBundle\Accessor;

interface ViewableAccessorInterface
{
    /**
     * Access the property on the object for which you want to create custom views.
     * Ex: $object->getId(),
     *     will render view_{id}.html.twig if exists,
     *     will default to view.html.twig if not
     *
     * @param $object
     *
     * @return string
     */
    public function getAccessor($object);
}
