<?php

namespace Happyr\SerializerBundle\Metadata;

/**
 * A class to help build upp metadata.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Metadata
{
    /**
     * @var string fqn of the class
     */
    private $class;

    /**
     * @var array
     */
    private $classMetadata = [];

    /**
     * @var array
     */
    private $methodMetadata = [];

    /**
     * @var array
     */
    private $propertyMetadata = [];

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    /**
     * @param array $metadata
     */
    public static function convertToStrings(array $metadata)
    {
        $data = [];

        /** @var Metadata $m */
        foreach ($metadata as $m) {
            $data[$m->getClass()] = ['fqcn' => $m->getClass(), 'class' => $m->getClassMetadata(), 'property' => $m->getPropertyMetadata(), 'method' => $m->getMethodMetadata()];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     *
     * @return Metadata
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function getClassMetadata()
    {
        return $this->classMetadata;
    }

    /**
     * @param $classMetadata
     *
     * @return $this
     */
    public function setClassMetadata($classMetadata)
    {
        $this->classMetadata = $classMetadata;

        return $this;
    }

    /**
     * @return array
     */
    public function getMethodMetadata()
    {
        return $this->methodMetadata;
    }

    /**
     * @param $name
     * @param $methodMetadata
     *
     * @return $this
     */
    public function setMethodMetadata($name, $methodMetadata)
    {
        $this->methodMetadata[$name] = $methodMetadata;

        return $this;
    }

    /**
     * @return array
     */
    public function getPropertyMetadata()
    {
        return $this->propertyMetadata;
    }

    /**
     * @param $name
     * @param $properyMetadata
     *
     * @return $this
     */
    public function setPropertyMetadata($name, $properyMetadata)
    {
        $this->propertyMetadata[$name] = $properyMetadata;

        return $this;
    }
}
