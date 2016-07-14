<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\Exclude\Car;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ExcludeTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car(true));

        $this->assertFalse(isset($data['model']));
        $this->assertTrue(isset($data['size']));
    }

    public function testDeserialize()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'size', 'size_value');
    }
}
