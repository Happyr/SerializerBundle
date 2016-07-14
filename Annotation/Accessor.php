<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Accessor implements SerializerAnnotation
{
    /**
     * @var string
     */
    public $getter;
    /**
     * @var string
     */
    public $setter;

    public function getName()
    {
        return 'accessor';
    }

    public function getValue()
    {
        return ['setter' => $this->setter, 'getter' => $this->getter];
    }
}
