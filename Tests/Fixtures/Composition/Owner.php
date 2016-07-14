<?php

namespace Happyr\SerializerBundle\Tests\Fixtures\Composition;

use Happyr\SerializerBundle\Annotation as Serializer;


/**
 * @Serializer\ExclusionPolicy("none")
 */
class Owner
{
    private $name;

    /**
     * @Serializer\Type("Happyr\SerializerBundle\Tests\Fixtures\Composition\Car")
     */
    private $car;

    private $birtday;

    public function __construct($withValues = false)
    {
        if ($withValues) {
            $this->name = 'Foobar';
            $this->car = new Car(true);
            $this->birtday = new \DateTime('-21years');
        }
    }

    /**
     * @return Car
     */
    public function getCar()
    {
        return $this->car;
    }
}
