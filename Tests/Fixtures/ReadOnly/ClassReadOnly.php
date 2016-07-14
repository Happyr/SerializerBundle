<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\ReadOnly;

use Happyr\SerializerBundle\Annotation as Serializer;

/**
 * @Serializer\ReadOnly()
 */
class ClassReadOnly
{
    /**
     * @Serializer\ReadOnly(false)
     */
    private $model;

    private $size;

    /**
     * @Serializer\ReadOnly()
     */
    private $color;

    public function __construct($withValues = false)
    {
        if ($withValues) {
            $this->model = 'val_model';
            $this->size = 'val_size';
            $this->color = 'val_color';
        }
    }
}
