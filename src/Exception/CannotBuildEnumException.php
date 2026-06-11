<?php

// GREP_SUMMARY: CannotBuildEnumException, enum build failure, type mismatch

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_CannotBuildEnumException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when data type is incompatible with enum construction (non-integer for BackedEnum, non-string for UnitEnum).
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class CannotBuildEnumException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build enum from given data';
    }
}
// endregion CLASS_CannotBuildEnumException
