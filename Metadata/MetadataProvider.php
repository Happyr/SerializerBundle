<?php

namespace Happyr\SerializerBundle\Metadata;

/**
 * This is the class that returns the data about the models.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class MetadataProvider
{
    /**
     * @var MetadataReader[]
     */
    private $readers;

    /**
     * @param MetadataReader[] $readers
     */
    public function __construct(array $readers)
    {
        $this->readers = $readers;
    }

    /**
     * @return Metadata[]
     */
    public function getMetadata()
    {
        $metadata = [];
        foreach ($this->readers as $reader) {
            $metadata = array_merge($metadata, $reader->getMetadata());
        }

        return $metadata;
    }
}
