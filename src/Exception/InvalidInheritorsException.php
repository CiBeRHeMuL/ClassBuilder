<?php

// GREP_SUMMARY: InvalidInheritorsException, self-referencing inheritor

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_InvalidInheritorsException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when AvailableInheritors contains the parent class itself, creating a self-reference.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class InvalidInheritorsException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'invalid inheritors detected (all inheritors must extends checking class)';
    }
}
// endregion CLASS_InvalidInheritorsException
