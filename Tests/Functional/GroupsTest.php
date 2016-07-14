<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\Groups\Car;

class GroupsTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car(true), ['groups' => ['First']]);
        $this->assertTrue(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertFalse(isset($data['color']));

        $data = $this->serialize(new Car(true), ['groups' => ['Second']]);
        $this->assertTrue(isset($data['model']));
        $this->assertFalse(isset($data['size']));
        $this->assertFalse(isset($data['color']));

        $data = $this->serialize(new Car(true), ['groups' => ['First', 'Second']]);
        $this->assertTrue(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertFalse(isset($data['color']));

        $data = $this->serialize(new Car(true), ['groups' => ['Default', 'Second']]);
        $this->assertTrue(isset($data['model']));
        $this->assertFalse(isset($data['size']));
        $this->assertTrue(isset($data['color']));

        $data = $this->serialize(new Car(true), ['groups' => []]);
        $this->assertTrue(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertTrue(isset($data['color']));
    }

    public function testDeserialize()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value', 'color' => 'color_value'];

        $obj = $this->deserialize($data, Car::class, ['groups' => ['First']]);
        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', null);

        $obj = $this->deserialize($data, Car::class, ['groups' => ['Second']]);
        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', null);
        $this->assertPropertyValue($obj, 'color', null);

        $obj = $this->deserialize($data, Car::class, ['groups' => ['First', 'Second']]);
        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', null);

        $obj = $this->deserialize($data, Car::class, ['groups' => ['Default', 'Second']]);
        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', null);
        $this->assertPropertyValue($obj, 'color', 'color_value');

        $obj = $this->deserialize($data, Car::class, ['groups' => []]);
        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', 'color_value');
    }
}
