<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\Tests\Fixtures\ExclusionPolicy\ExcludeAll;
use Happyr\SerializerBundle\Tests\Fixtures\ExclusionPolicy\ExcludeDefault;
use Happyr\SerializerBundle\Tests\Fixtures\ExclusionPolicy\ExcludeNone;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ExclusionPolicyTest extends SerializerTestCase
{
    public function testSerializeDefault()
    {
        $data = $this->serialize(new ExcludeDefault(true));

        $this->assertFalse(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertTrue(isset($data['color']));
    }

    public function testSerializeNone()
    {
        $data = $this->serialize(new ExcludeNone(true));

        $this->assertFalse(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertTrue(isset($data['color']));
    }

    public function testSerializeAll()
    {
        $data = $this->serialize(new ExcludeAll(true));

        $this->assertFalse(isset($data['model']));
        $this->assertTrue(isset($data['size']));
        $this->assertFalse(isset($data['color']));
    }

    public function testDeserializeDefault()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value', 'color' => 'color_value'];
        $obj = $this->deserialize($data, ExcludeDefault::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', 'color_value');
    }

    public function testDeserializeNone()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value', 'color' => 'color_value'];
        $obj = $this->deserialize($data, ExcludeNone::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', 'color_value');
    }

    public function testDeserializeAll()
    {
        $data = ['model' => 'model_value', 'size' => 'size_value', 'color' => 'color_value'];
        $obj = $this->deserialize($data, ExcludeAll::class);

        $this->assertPropertyValue($obj, 'model', null);
        $this->assertPropertyValue($obj, 'size', 'size_value');
        $this->assertPropertyValue($obj, 'color', null);
    }
}
