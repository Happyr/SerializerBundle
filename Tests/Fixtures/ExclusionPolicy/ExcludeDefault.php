<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\ExclusionPolicy;

use Happyr\SerializerBundle\Annotation as Serializer;

class ExcludeDefault
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
