<?php

// GREP_SUMMARY: InheritorsNotSetException, missing inheritors, abstract/interface no inheritors

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_InheritorsNotSetException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when an abstract class or interface has no AvailableInheritors attribute, so ClassBuilder cannot determine which concrete class to instantiate.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class InheritorsNotSetException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'inheritors not set';
    }
}
// endregion CLASS_InheritorsNotSetException
