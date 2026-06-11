<?php

// GREP_SUMMARY: ClassNotFoundException, class not found, invalid type

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_ClassNotFoundException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when the specified class does not exist or cannot be autoloaded.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class ClassNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'class not found';
    }
}
// endregion CLASS_ClassNotFoundException
