<?php

// GREP_SUMMARY: CannotBuildException, general build failure, no matching type

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_CannotBuildException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when no type in a union or intersection list is able to construct a value from the given data.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class CannotBuildException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build value from given data';
    }
}
// endregion CLASS_CannotBuildException
