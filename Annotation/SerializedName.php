<?php

namespace Happyr\SerializerBundle\Annotation;

use Happyr\SerializerBundle\Exception\RuntimeException;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class SerializedName implements SerializerAnnotation
{
    private $value;

    /**
     * @param $name
     */
    public function __construct(array $values)
    {
        if (!is_string($values['value'])) {
            throw new RuntimeException('"value" must be a string.');
        }

        $this->value = $values['value'];
    }

    public function getName()
    {
        return 'serialized_name';
    }

    public function getValue()
    {
        return $this->value;
    }
}
