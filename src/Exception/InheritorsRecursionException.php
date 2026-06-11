<?php

// GREP_SUMMARY: InheritorsRecursionException, inheritor not subclass, invalid inheritance

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_InheritorsRecursionException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when an inheritor listed in AvailableInheritors is not a valid subclass of the parent class.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class InheritorsRecursionException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'possible recursion detected while checking inheritors'
            . ' (all inheritors must extends class and be not equal to checking class)';
    }
}
// endregion CLASS_InheritorsRecursionException
