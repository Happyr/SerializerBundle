<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class Groups implements SerializerAnnotation
{
    /**
     * @var array<string> @Required
     */
    public $groups;

    public function getName()
    {
        return 'groups';
    }

    public function getValue()
    {
        return $this->groups;
    }
}
