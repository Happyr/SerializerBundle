<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\Expose;

use Happyr\SerializerBundle\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Car
{
    /**
     * @Serializer\Expose
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
