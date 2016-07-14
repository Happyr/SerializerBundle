<?php

namespace Happyr\SerializerBundle\Normalizer;

use Happyr\SerializerBundle\Annotation\ExclusionPolicy;
use Happyr\SerializerBundle\Metadata\Metadata;
use Happyr\SerializerBundle\Normalizer\Helper\PropertyNameConverter;
use Happyr\SerializerBundle\PropertyAccess\ReflectionPropertyAccess;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;
use Symfony\Component\Serializer\Exception\LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class MetadataAwareDenormalizer extends SerializerAwareNormalizer implements DenormalizerInterface
{
    /**
     * @var Metadata[]
     */
    private $metadata;

    /**
     * @var PropertyNameConverter
     */
    private $propertyNameConverter;

    /**
     * @param array                 $metadata
     * @param PropertyNameConverter $pnc
     */
    public function __construct(array $metadata, PropertyNameConverter $pnc)
    {
        $this->metadata = $metadata;
        $this->propertyNameConverter = $pnc;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $meta = $this->getMetadata($class);
        $normalizedData = (array) $data;
        $object = $this->getInstance($class, $context);

        foreach ($normalizedData as $attribute => $value) {
            if (null === $propertyName = $this->getPropertyName($meta, $attribute)) {
                // Name is invalid, skip this
                continue;
            }

            if (null !== $value && !is_scalar($value)) {
                if (!$this->serializer instanceof DenormalizerInterface) {
                    throw new LogicException(sprintf('Cannot denormalize attribute "%s" because injected serializer is not a normalizer', $attribute));
                }

                if (null !== $propertyType = $this->getPropertyType($meta, $propertyName)) {
                    $value = $this->serializer->denormalize($value, $propertyType, $format, $context);
                }
            }

            $this->setPropertyValue($object, $meta, $propertyName, $value, $context);
        }

        return $object;
    }

    /**
     * Set the property value.
     *
     * @param $object
     * @param array $meta
     * @param $propertyName
     * @param $value
     * @param array $context
     */
    private function setPropertyValue($object, array $meta, $propertyName, $value, array $context)
    {
        if (!isset($meta['property'][$propertyName])) {
            $meta['property'][$propertyName] = [];
        }

        // Default exclusion policy is NONE
        $exclusionPolicy = isset($meta['class']['exclusion_policy']) ? $meta['class']['exclusion_policy'] : ExclusionPolicy::NONE;

        // If this property should be in the output
        $included = $exclusionPolicy === ExclusionPolicy::NONE;

        // If read_only is defined and true
        $readOnly = false;
        if (isset($meta['class']['read_only']) ? $meta['class']['read_only'] : false) {
            $readOnly = true;
        }

        $groups = ['Default'];
        $accessor = null;
        foreach ($meta['property'][$propertyName] as $name => $metaValue) {
            switch ($name) {
                case 'exclude';
                    // Skip this
                    return;
                case 'read_only':
                    if ($metaValue === true) {
                        return;
                    }
                    // If readOnly = false we should include this
                    $readOnly = false;
                    break;
                case 'expose':
                    $included = true;
                    break;
                case 'accessor':
                    if (isset($metaValue['setter'])) {
                        $accessor = $metaValue['setter'];
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

        if (!$included || $readOnly) {
            return;
        }

        if ($accessor) {
            $object->$accessor($value);
        } else {
            ReflectionPropertyAccess::set($object, $propertyName, $value);
        }
    }

    /**
     * Get instance of the class.
     *
     * @param string $class
     * @param array  $context
     *
     * @return object
     */
    private function getInstance($class, array $context)
    {
        if (
            isset($context[AbstractNormalizer::OBJECT_TO_POPULATE]) &&
            is_object($context[AbstractNormalizer::OBJECT_TO_POPULATE]) &&
            $context[AbstractNormalizer::OBJECT_TO_POPULATE] instanceof $class
        ) {
            $object = $context[AbstractNormalizer::OBJECT_TO_POPULATE];
            unset($context[AbstractNormalizer::OBJECT_TO_POPULATE]);

            return $object;
        }

        $reflectionClass = new \ReflectionClass($class);
        $constructor = $reflectionClass->getConstructor();
        if (!$constructor) {
            return new $class();
        }

        return $reflectionClass->newInstanceWithoutConstructor();
    }

    /**
     * Get the property name for this normalized key name. This will aslo verify if the name is correct.
     *
     * @param array  $rootMeta
     * @param string $serializedName
     *
     * @return string|null
     */
    private function getPropertyName($rootMeta, $serializedName)
    {
        $propertyName = $this->propertyNameConverter->getPropertyName($rootMeta, $serializedName);

        $meta = isset($rootMeta['property'][$propertyName]) ? $rootMeta['property'][$propertyName] : [];
        $verify = $this->propertyNameConverter->getSerializedName($meta, $propertyName);

        if ($serializedName === $verify) {
            return $propertyName;
        }

        // The $serializedName was fake
        return;
    }

    /**
     * Get the type of this property.
     *
     * @param array  $meta
     * @param string $name
     *
     * @return null|string
     */
    private function getPropertyType($meta, $name)
    {
        foreach ($meta['property'][$name] as $metaName => $value) {
            if ($metaName === 'type') {
                return $value;
            }
        }

        return;
    }

    /**
     * @param mixed  $data
     * @param string $type
     * @param null   $format
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return isset($this->metadata[$type]);
    }

    /**
     * @param string $class
     *
     * @return Metadata|mixed
     */
    private function getMetadata($class)
    {
        return $this->metadata[$class];
    }
}
