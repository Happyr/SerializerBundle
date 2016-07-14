<?php

namespace Happyr\SerializerBundle\PropertyManager;

/**
 * An easy way to get properties from an object.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ReflectionPropertyAccess
{
    /**
     * @param $object
     * @param $propertyName
     * @param $value
     */
    public static function set($object, $propertyName, $value)
    {
        $reflectionProperty = self::getReflectionProperty($object, $propertyName);
        $reflectionProperty->setValue($object, $value);
    }

    /**
     * @param $object
     * @param $propertyName
     *
     * @return mixed
     */
    public static function get($object, $propertyName)
    {
        $reflectionProperty = self::getReflectionProperty($object, $propertyName);

        return $reflectionProperty->getValue($object);
    }

    /**
     * @param $object
     * @param $propertyName
     *
     * @return \ReflectionProperty
     */
    private static function getReflectionProperty($object, $propertyName)
    {
        $reflectionClass = new \ReflectionClass($object);

        $reflectionProperty = $reflectionClass->getProperty($propertyName);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }
}
