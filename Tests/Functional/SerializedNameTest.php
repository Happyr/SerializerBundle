<?php

namespace Happyr\SerializerBundle\Tests\Functional;


use Happyr\SerializerBundle\Tests\Fixtures\SerializedName\Car;

class SerializedNameTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car());

        $this->assertTrue(isset($data['super_model']));
        $this->assertTrue(isset($data['car_size']));
        $this->assertTrue(isset($data['color']));
    }

    public function testDeserialize()
    {
        $data = ['super_model'=>'model_val', 'car_size'=>'size_val', 'color'=>'color_val'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', 'model_val');
        $this->assertPropertyValue($obj, 'carSize', 'size_val');
        $this->assertPropertyValue($obj, 'color', 'color_val');
    }


    public function testDeserializeWhenIgnoringSerializedName()
    {
        $data = ['model'=>'model_val', 'carSize'=>'size_val', 'color'=>'color_val'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'carSize', null);
        $this->assertPropertyValue($obj, 'color', 'color_val');
    }
}