<?php

namespace Happyr\SerializerBundle\Normalizer;

/**
 *
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
trait GroupValidationTrait
{
    /**
     * @param array $context
     * @param array $groups
     *
     * @return bool
     */
    protected function includeBasedOnGroup(array $context, array $groups)
    {
        foreach ($context['groups'] as $group) {
            if (in_array($group, $groups)) {
                return $included = true;
            }
        }

        return false;
    }
}