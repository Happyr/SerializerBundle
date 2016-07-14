<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
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
