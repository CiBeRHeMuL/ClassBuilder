<?php

// GREP_SUMMARY: EnumNotFoundException, enum not found, invalid enum type

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_EnumNotFoundException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a requested type is not a valid enum (neither BackedEnum nor UnitEnum).
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class EnumNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'enum not found';
    }
}
// endregion CLASS_EnumNotFoundException
