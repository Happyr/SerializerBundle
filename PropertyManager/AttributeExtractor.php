<?php

namespace Happyr\SerializerBundle\PropertyManager;

/**
 * Extract attributes from object.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AttributeExtractor
{
    /**
     * @var array
     */
    private $attributesCache = [];

    /**
     * Gets and caches attributes for this class and context.
     *
     * @param object|string $object
     *
     * @return string[]
     */
    public function getAttributes($object)
    {
        if (is_string($object)) {
            $class = $object;
        } else {
            $class = get_class($object);
        }

        // get cache key
        if (false !== $key = $this->getCacheKey($class)) {
            if (isset($this->attributesCache[$key])) {
                return $this->attributesCache[$key];
            }
        }

        return $this->attributesCache[$key] = $this->extractAttributes($class);
    }

    /**
     * Extracts attributes for this class and context.
     *
     * @param string $class
     *
     * @return string[]
     */
    private function extractAttributes($class)
    {
        // If not using groups, detect manually
        $attributes = ['property' => [], 'method' => []];

        // methods
        $reflClass = new \ReflectionClass($class);
        foreach ($reflClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $reflMethod) {
            if (
                $reflMethod->getNumberOfRequiredParameters() !== 0 ||
                $reflMethod->isStatic() ||
                $reflMethod->isConstructor() ||
                $reflMethod->isDestructor()
            ) {
                continue;
            }

            $name = $reflMethod->name;

            $attributes['method'][$name] = true;
        }

        // properties
        foreach ($reflClass->getProperties() as $reflProperty) {
            if ($reflProperty->isStatic()) {
                continue;
            }

            $attributes['property'][$reflProperty->name] = true;
        }

        return $attributes;
    }

    /**
     * Get a good cache key for this class.
     *
     * @param $class
     *
     * @return bool|string
     */
    private function getCacheKey($class)
    {
        try {
            return md5($class);
        } catch (\Exception $e) {
            // The context cannot be serialized, skip the cache
            return false;
        }
    }
}
