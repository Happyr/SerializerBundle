<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\SerializedName;


use Happyr\SerializerBundle\Annotation as Serializer;


/**
 * @Serializer\ExclusionPolicy("none")
 */
class Car
{
    /**
     * @Serializer\SerializedName("super_model")
     */
    private $model;

    private $carSize;

    private $color;

    /**
     *
     */
    public function __construct($withValues = false)
    {
        if ($withValues) {
            $this->model = 'val_model';
            $this->carSize = 'val_size';
            $this->color = 'val_color';
        }
    }


}