<?php

namespace Happyr\SerializerBundle\Normalizer;

use Happyr\SerializerBundle\Annotation\ExclusionPolicy;
use Happyr\SerializerBundle\Metadata\AttributeExtractor;
use Happyr\SerializerBundle\Metadata\Metadata;
use Happyr\SerializerBundle\Normalizer\Helper\PropertyNameConverter;
use Happyr\SerializerBundle\PropertyAccess\ReflectionPropertyAccess;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class MetadataAwareNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    /**
     * @var Metadata[]
     */
    private $metadata;

    /**
     * @var AttributeExtractor
     */
    private $attributeExtractor;

    /**
     * @var PropertyNameConverter
     */
    private $propertyNameConverter;

    /**
     *
     * @param array $metadata
     * @param PropertyNameConverter $pnc
     */
    public function __construct(array $metadata, PropertyNameConverter $pnc)
    {
        $this->metadata = $metadata;
        $this->attributeExtractor = new AttributeExtractor();
        $this->propertyNameConverter = $pnc;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $meta = $this->getMetadata($object);
        $attributes = $this->attributeExtractor->getAttributes($object);

        $normalizedData = [];
        foreach ($attributes['property'] as $propertyName => $bool) {
            $this->normalizeProperty($normalizedData, $meta, $object, $propertyName, $context);
        }
        foreach ($attributes['method'] as $propertyName => $bool) {
            $this->normalizeMethod($normalizedData, $meta, $object, $propertyName, $context);
        }

        foreach ($normalizedData as $name => $value) {
            if (null !== $value && !is_scalar($value)) {
                if (!$this->serializer instanceof NormalizerInterface) {
                    throw new LogicException(sprintf('Cannot normalize attribute "%s" because injected serializer is not a normalizer', $name));
                }

                $normalizedData[$name] = $this->serializer->normalize($value, $format, $context);
            }
        }

        return $normalizedData;
    }

    protected function normalizeProperty(array &$normalizedData, array $meta, $object, $propertyName, array $context)
    {
        if (!isset($meta['property'][$propertyName])) {
            $meta['property'][$propertyName] = [];
        }

        // Default exclusion policy is ALL
        $exclusionPolicy = isset($meta['class']['exclusion_policy']) ? $meta['class']['exclusion_policy'] : ExclusionPolicy::ALL;

        // If this property should be in the output
        $included = $exclusionPolicy === ExclusionPolicy::NONE;

        $groups = ['Default'];
        $value = ReflectionPropertyAccess::get($object, $propertyName);
        foreach ($meta['property'][$propertyName] as $name => $metaValue) {
            switch ($name) {
                case 'exclude';
                    // Skip this
                    return;
                case 'expose':
                    $included = true;
                    break;
                case 'accessor':
                    if (isset($metaValue['getter'])) {
                        $accessor = $metaValue['getter'];
                        $value = $object->$accessor();
                    }
                    break;
                case 'groups':
                    $groups = $metaValue;
                    break;
            }
        }

        // Validate context groups
        if (!empty($context['groups'])) {
            $included = false;
            foreach ($context['groups'] as $group) {
                if (in_array($group, $groups)) {
                    $included = true;
                    break;
                }
            }
        }

        if (!$included) {
            return;
        }

        $serializedName = $this->propertyNameConverter->getSerializedName($meta['property'][$propertyName], $propertyName);
        $normalizedData[$serializedName] = $value;
    }

    protected function normalizeMethod(array &$normalizedData, array $meta, $object, $methodName, array $context)
    {
        if (!isset($meta['method'][$methodName])) {
            $meta['method'][$methodName] = [];
        }

        // Methods are never serialized by default
        $included = false;

        $groups = ['Default'];
        foreach ($meta['method'][$methodName] as $name => $metaValue) {
            switch ($name) {
                case 'expose':
                    $included = true;
                    break;
                case 'serialized_name':
                    $serializedName = $metaValue;
                    break;
                case 'groups':
                    $groups = $metaValue;
                    break;
            }
        }

        // Validate context groups
        if (!empty($context['groups'])) {
            $included = false;
            foreach ($context['groups'] as $group) {
                if (in_array($group, $groups)) {
                    $included = true;
                    break;
                }
            }
        }

        if (!$included) {
            return;
        }

        $serializedName = $this->propertyNameConverter->getSerializedName($meta['method'][$methodName], $methodName);
        $normalizedData[$serializedName] = $object->$methodName();
    }

    /**
     * @param mixed $data
     * @param null  $format
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        $class = get_class($data);

        return isset($this->metadata[$class]);
    }

    /**
     * @param $object
     */
    private function getMetadata($object)
    {
        $class = get_class($object);

        return $this->metadata[$class];
    }
}
