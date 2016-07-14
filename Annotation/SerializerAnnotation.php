<?php

namespace Happyr\SerializerBundle\Annotation;

interface SerializerAnnotation
{
    /**
     * The name or identifier for this metadata.
     *
     * @return string
     */
    public function getName();

    /**
     * The value of this annotation.
     *
     * @return mixed
     */
    public function getValue();
}
