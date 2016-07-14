<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\ReadOnly\Car;
use Happyr\SerializerBundle\Tests\Fixtures\ReadOnly\ClassReadOnly;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ReadOnlyTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car(true));

        $this->assertTrue(isset($data['model']));
        $this->assertTrue(isset($data['size']));
    }

    public function testDeserialize()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'size', 'size_value');
    }

    public function testSerializeReadOnlyClass()
    {
        $data = $this->serialize(new ClassReadOnly(true));

        $this->assertTrue(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertTrue(isset($data['color']));
    }

    public function testDeserializeReadOnlyClass()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value', 'color' => 'color_value'];
        $obj = $this->deserialize($data, ClassReadOnly::class);

        $this->assertPropertyValue($obj, 'model', 'model_value');
        $this->assertPropertyValue($obj, 'size', null);
        $this->assertPropertyValue($obj, 'color', null);
    }
}
