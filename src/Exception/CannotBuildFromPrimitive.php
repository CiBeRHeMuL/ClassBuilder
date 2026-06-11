<?php

// GREP_SUMMARY: CannotBuildFromPrimitive, scalar build failure, parameter count

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_CannotBuildFromPrimitive [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a class marked as CanBeBuiltFromScalar has more than one required constructor parameter.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class CannotBuildFromPrimitive extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build value from primitive data';
    }
}
// endregion CLASS_CannotBuildFromPrimitive
