<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Happyr\SerializerBundle\PropertyManager\ReflectionPropertyAccess;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerTestCase extends WebTestCase
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function setUp()
    {
        static::bootKernel();
    }

    /**
     * @return SerializerInterface
     */
    protected function getSerializer()
    {
        if ($this->serializer) {
            return $this->serializer;
        }

        $container = static::$kernel->getContainer();

        return $this->serializer = $container->get('serializer');
    }

    /**
     * @param $obj
     *
     * @return array assoc
     */
    protected function serialize($obj, array $context = array())
    {
        $json = $this->getSerializer()->serialize($obj, 'json', $context);

        return json_decode($json, true);
    }

    /**
     * @param array  $data
     * @param string $type
     * @param array  $context
     *
     * @return object
     */
    protected function deserialize(array $data, $type, array $context = array())
    {
        return $this->getSerializer()->deserialize(json_encode($data), $type, 'json', $context);
    }

    /**
     * Assert $obj->name is $value.
     *
     * @param object $obj
     * @param string $name
     * @param mixed  $value
     */
    protected function assertPropertyValue($obj, $name, $value)
    {
        $this->assertEquals($value, ReflectionPropertyAccess::get($obj, $name));
    }
}
