<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Type implements SerializerAnnotation
{
    public $value;

    public function getName()
    {
        return 'type';
    }

    public function getValue()
    {
        return $this->value;
    }
}
