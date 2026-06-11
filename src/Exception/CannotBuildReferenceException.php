<?php

// GREP_SUMMARY: CannotBuildReferenceException, circular reference, recursion

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_CannotBuildReferenceException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a circular reference is detected during object construction.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class CannotBuildReferenceException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build referenced parameter without default value';
    }
}
// endregion CLASS_CannotBuildReferenceException
