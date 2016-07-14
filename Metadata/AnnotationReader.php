<?php

namespace Happyr\SerializerBundle\Metadata;

use Happyr\SerializerBundle\Annotation\SerializerAnnotation;
use Symfony\Component\Finder\Finder;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Read annotations.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class AnnotationReader implements MetadataReader
{
    /**
     * @var array
     */
    private $paths;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var AttributeExtractor
     */
    private $attributeExtractor;

    /**
     * @param $paths
     */
    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
        $this->reader = new Reader();
        $this->attributeExtractor = new AttributeExtractor();
    }

    /**
     * @return Metadata[]
     */
    public function getMetadata()
    {
        // Create a function to filter out our annotations
        $filterAnnotations = function ($annotation) {
            return $annotation instanceof SerializerAnnotation;
        };

        $metadatas = [];
        foreach ($this->paths as $path) {
            $finder = new Finder();
            $finder->in($path)->notName('*Test.php')->name('*.php');
            /** @var SplFileInfo $file */
            foreach ($finder as $file) {
                if (null === $fqcn = $this->getFullyQualifiedClassName($file->getPathname())) {
                    continue;
                }
                $metadata = new Metadata($fqcn);

                $attributes = $this->attributeExtractor->getAttributes($fqcn);
                $reflectionClass = new \ReflectionClass($fqcn);
                $classAnnotations = array_filter($this->reader->getClassAnnotations($reflectionClass), $filterAnnotations);

                $propertyAnnotations = [];
                foreach ($attributes['property'] as $propertyName => $bool) {
                    $propertyAnnotations[$propertyName] = array_filter($this->reader->getPropertyAnnotations($reflectionClass->getProperty($propertyName)), $filterAnnotations);
                }

                $methodAnnotations = [];
                foreach ($attributes['method'] as $methodName => $bool) {
                    $methodAnnotations[$methodName] = array_filter($this->reader->getMethodAnnotations($reflectionClass->getMethod($methodName)), $filterAnnotations);
                }

                if ($this->buildMetadataFromAnnotation($metadata, $classAnnotations, $methodAnnotations, $propertyAnnotations)) {
                    $metadatas[] = $metadata;
                }
            }
        }

        return $metadatas;
    }

    /**
     * Build a metadata object from annotations.
     *
     * @param Metadata $metadata
     * @param $classAnnotations
     * @param $methodAnnotations
     * @param $propertyAnnotations
     */
    private function buildMetadataFromAnnotation(Metadata $metadata, $classAnnotations, $methodAnnotations, $propertyAnnotations)
    {
        $return = false;
        $a = [
            'setPropertyMetadata' => $propertyAnnotations,
            'setMethodMetadata' => $methodAnnotations,
        ];

        foreach ($a as $function => $typeAnnotations) {
            foreach ($typeAnnotations as $name => $annotations) {
                $data = [];
                /** @var SerializerAnnotation $annotation */
                foreach ($annotations as $annotation) {
                    $data[$annotation->getName()] = $annotation->getValue();
                }

                $metadata->$function($name, $data);
                if (count($data) > 0) {
                    $return = true;
                }
            }
        }

        // Class annotations
        /** @var SerializerAnnotation $annotation */
        $data = [];
        foreach ($classAnnotations as $annotation) {
            $data[$annotation->getName()] = $annotation->getValue();
        }
        $metadata->setClassMetadata($data);
        if (count($data) > 0) {
            $return = true;
        }

        return $return;
    }

    /**
     * @param string $path
     *
     * @return null|string
     */
    private function getFullyQualifiedClassName($path)
    {
        $src = file_get_contents($path);
        $filename = basename($path);
        $classname = substr($filename, 0, -4);

        if (preg_match('|^namespace\s+(.+?);$|sm', $src, $matches)) {
            return $matches[1].'\\'.$classname;
        }

        return null;
    }
}
