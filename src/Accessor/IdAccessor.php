<?php

namespace Etudor\ViewableBundle\Accessor;

class IdAccessor implements ViewableAccessorInterface
{
    /**
     * @inheritdoc
     */
    public function getAccessor($object)
    {
        return $object->getId();
    }
}
