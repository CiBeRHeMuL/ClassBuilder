<?php

// GREP_SUMMARY: ValueNotFoundException, required parameter missing

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_ValueNotFoundException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a required constructor parameter has no matching key in the input data.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class ValueNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'value not found';
    }
}
// endregion CLASS_ValueNotFoundException
