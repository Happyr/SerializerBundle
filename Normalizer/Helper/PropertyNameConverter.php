<?php

namespace Happyr\SerializerBundle\Normalizer\Helper;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * This class is aware of the meta data.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class PropertyNameConverter
{
    /**
     * @var NameConverterInterface
     */
    private $nameConverter;

    /**
     * @param NameConverterInterface $nameConverter
     */
    public function __construct(NameConverterInterface $nameConverter = null)
    {
        $this->nameConverter = $nameConverter;
        if ($this->nameConverter === null) {
            $this->nameConverter = new CamelCaseToSnakeCaseNameConverter();
        }
    }

    /**
     * Get the serialized name.
     *
     * @param array  $propertyMeta
     * @param string $propertyName
     *
     * @return string
     */
    public function getSerializedName(array $propertyMeta, $propertyName)
    {
        foreach ($propertyMeta as $metaName => $metaValue) {
            if ($metaName === 'serialized_name') {
                return $metaValue;
            }
        }

        return $this->nameConverter->normalize($propertyName);
    }

    /**
     * Get the property name form a serialized name and meta.
     *
     * @param array  $meta           root
     * @param string $serializedName
     *
     * @return string
     */
    public function getPropertyName($meta, $serializedName)
    {
        // Try find the name in the meta values
        foreach ($meta['property'] as $prop => $propertyMeta) {
            foreach ($propertyMeta as $metaName => $metaValue) {
                if ($metaName === 'serialized_name' && $metaValue === $serializedName) {
                    return $prop;
                }
            }
        }

        // Fallback on the name converter
        return $this->nameConverter->denormalize($serializedName);
    }
}
