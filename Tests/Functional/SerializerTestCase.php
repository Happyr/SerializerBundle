<?php

namespace Happyr\SerializerBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SerializerTestCase extends WebTestCase
{
    public static function setUpBeforeClass()
    {
        static::bootKernel();
    }

    protected function getSerializer()
    {
        $container = static::$kernel->getContainer();

        return $container->get('serializer');
    }
}