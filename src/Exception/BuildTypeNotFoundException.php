<?php

// GREP_SUMMARY: BuildTypeNotFoundException, type not found, build error

namespace AndrewGos\ClassBuilder\Exception;

// region CLASS_BuildTypeNotFoundException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when no builder strategy matches the given type, indicating an unsupported type was requested.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack) -> void (throws)
 * @complexity 1
 */
class BuildTypeNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot find types to build parameter';
    }
}
// endregion CLASS_BuildTypeNotFoundException
