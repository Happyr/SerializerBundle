<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\Composition\Car;
use Happyr\SerializerBundle\Tests\Fixtures\Composition\Owner;

/**
 * Test what happens when a object owns another.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CompositionTest extends SerializerTestCase
{
    public function testSerialize()
    {
        $data = $this->serialize(new Owner(true));

        $this->assertTrue(isset($data['car']));
        $this->assertTrue(isset($data['car']['color']));
        $this->assertTrue(isset($data['name']));
        $this->assertTrue(isset($data['birthday']));
    }

    public function testDeserialize()
    {
        $data = json_decode('{"name":"Foobar","car":{"super_model":"val_model","car_size":"val_size","color":"val_color"},"birthday":"1995-07-14T20:07:41+02:00"}', true);
        $obj = $this->deserialize($data, Owner::class);

        $this->assertPropertyValue($obj, 'name', 'Foobar');
        $car = $obj->getCar();
        $this->assertInstanceOf(Car::class, $car);
        $this->assertPropertyValue($car, 'color', 'val_color');
    }
}
