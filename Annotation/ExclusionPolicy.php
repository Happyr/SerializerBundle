<?php

namespace Happyr\SerializerBundle\Annotation;

use Happyr\SerializerBundle\Exception\RuntimeException;

/**
 * @Annotation
 * @Target({"CLASS"})
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class ExclusionPolicy implements SerializerAnnotation
{
    const NONE = 'NONE';
    const ALL = 'ALL';

    public $value;

    public function __construct(array $values)
    {
        if (!is_string($values['value'])) {
            throw new RuntimeException('"value" must be a string.');
        }

        $this->value = strtoupper($values['value']);

        if (self::NONE !== $this->value && self::ALL !== $this->value) {
            throw new RuntimeException('Exclusion policy must either be "ALL", or "NONE".');
        }
    }

    public function getName()
    {
        return 'exclusion_policy';
    }

    public function getValue()
    {
        return $this->value;
    }
}
