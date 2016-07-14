<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\Accessor;

use Happyr\SerializerBundle\Annotation as Serializer;

class Car
{
    /**
     * @Serializer\Accessor({"getter":"getModel", "setter":"setModel"})
     */
    private $model = 'defaultValue';

    /**
     * @return mixed
     */
    public function getModel()
    {
        return 'getModel';
    }

    /**
     * @param mixed $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model.'_setter';

        return $this;
    }
}
