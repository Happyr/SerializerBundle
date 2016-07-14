<?php

namespace Happyr\SerializerBundle\Tests\Functional;


use Happyr\SerializerBundle\Tests\Fixtures\SerializedName\Car;

class SerializedNameTest extends SerializerTestCase
{
    public function testFoo()
    {
        $s = $this->getSerializer();
        $obj = new Car();

        $json = $s->serialize($obj, 'json');
        $data = json_decode($json, true);

        $this->assertTrue(isset($data['super_model']));
        $this->assertTrue(isset($data['car_size']));
        $this->assertTrue(isset($data['color']));
    }
}