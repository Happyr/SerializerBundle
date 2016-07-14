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
    private $model = 'val_model';

    private $carSize = 'val_sizel';

    private $color = 'val_color';
}