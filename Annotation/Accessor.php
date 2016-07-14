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

    /**
     *
     *
     * @param string $getter
     * @param string $setter
     */
    public function __construct(array $values)
    {
        $values = $values['value'];
        if (!empty($values['getter'])) {
            $this->getter = $values['getter'];
        }
        if (!empty($values['setter'])) {
            $this->setter = $values['setter'];
        }
    }


    public function getName()
    {
        return 'accessor';
    }

    public function getValue()
    {
        return ['setter' => $this->setter, 'getter' => $this->getter];
    }
}

