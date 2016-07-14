<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "CLASS"})
 */
final class ReadOnly implements SerializerAnnotation
{
    /**
     * @var bool
     */
    public $value = true;

    public function getName()
    {
        return 'read_only';
    }

    public function getValue()
    {
        return $this->value;
    }
}
