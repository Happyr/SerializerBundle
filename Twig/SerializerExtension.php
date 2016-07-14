<?php

namespace Happyr\SerializerBundle\Twig;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class SerializerExtension extends \Twig_Extension
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('serialize', [$this, 'serialize']),
        ];
    }

    /**
     * @param mixed  $object
     * @param string $type
     * @param array  $context
     */
    public function serialize($object, $type = 'json', array $context = [])
    {
        return $this->serializer->serialize($object, $type, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'happyr_serializer';
    }
}
