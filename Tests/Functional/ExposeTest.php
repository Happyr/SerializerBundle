<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\Expose\Car;

class ExposeTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car(true));

        $this->assertTrue(isset($data['model']));
        $this->assertFalse(isset($data['size']));
    }

    public function testDeserialize()
    {
        $data = ['model'=>'model_value', 'size'=>'size_value'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', null);
    }
}