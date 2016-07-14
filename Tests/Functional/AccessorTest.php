<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\Accessor\Car;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AccessorTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Car());

        $this->assertTrue(isset($data['model']));
        $this->assertEquals('getModel', $data['model']);
    }

    public function testDeserialize()
    {
        $data = ['model' => 'model_val'];
        $obj = $this->deserialize($data, Car::class);

        $this->assertPropertyValue($obj, 'model', 'model_val_setter');
    }
}
