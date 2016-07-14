<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\ExclusionPolicy;

use Happyr\SerializerBundle\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class ExcludeAll
{
    /**
     * @Serializer\Exclude
     */
    private $model;

    /**
     * @Serializer\Expose
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
