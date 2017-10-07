<?php

namespace Etudor\ViewableBundle\Accessor;

class IdAccessor implements ViewableAccessorInterface
{
    const PROPERTY_ID = 'id';

    /**
     * @inheritdoc
     */
    public function supports($object)
    {
        return property_exists($object, self::PROPERTY_ID);
    }

    /**
     * @inheritdoc
     */
    public function getAccessor($object)
    {
        return $object->getId();
    }
}
