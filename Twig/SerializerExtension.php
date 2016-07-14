<?php

namespace Happyr\SerializerBundle\Twig;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class SerializerExtension extends \Twig_Extension
{
    protected $serializer;

    public function getName()
    {
        return 'happyr_serializer';
    }

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('serialize', array($this, 'serialize')),
        );
    }

    /**
     * @param mixed  $object
     * @param string $type
     * @param array  $context
     */
    public function serialize($object, $type = 'json', array $context = array())
    {
        return $this->serializer->serialize($object, $type, $context);
    }
}
