<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\Groups;

use Happyr\SerializerBundle\Annotation as Serializer;

class Car
{
    /**
     * @Serializer\Groups({"First", "Second"})
     */
    private $model;

    /**
     * @Serializer\Groups({"First"})
     */
    private $size;

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
