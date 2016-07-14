<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\Exclude;

use Happyr\SerializerBundle\Annotation as Serializer;

class Car
{
    /**
     * @Serializer\Exclude
     */
    private $model;

    private $size;

    public function __construct($withValues = false)
    {
        if ($withValues) {
            $this->model = 'val_model';
            $this->size = 'val_size';
        }
    }
}
