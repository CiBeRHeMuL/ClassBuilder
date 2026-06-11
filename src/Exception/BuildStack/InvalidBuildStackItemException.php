<?php

// GREP_SUMMARY: InvalidBuildStackItemException, invalid stack transition, BuildStack validation

namespace AndrewGos\ClassBuilder\Exception\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;
use RuntimeException;

// region CLASS_InvalidBuildStackItemException [DOMAIN(8): Exception; CONCEPT(8): StackError; TECH(7): PHP8]
/**
 * @purpose Thrown by BuildStack::validatePrevElem() when attempting to push an item onto an incompatible parent stack item.
 * @io BuildStackItemSourceEnum, BuildStackItemSourceEnum -> void (throws)
 * @complexity 1
 */
class InvalidBuildStackItemException extends RuntimeException
{
    // region METHOD___construct [DOMAIN(8): Exception; CONCEPT(8): StackError; TECH(7): PHP8]
    /**
     * @purpose Generate an error message describing the invalid transition between two stack item types.
     * @io BuildStackItemSourceEnum, BuildStackItemSourceEnum -> void
     * @complexity 1
     *
     * @param BuildStackItemSourceEnum $pSource Parent stack item source type
     * @param BuildStackItemSourceEnum $source  Attempted child stack item source type
     */
    public function __construct(
        BuildStackItemSourceEnum $pSource,
        BuildStackItemSourceEnum $source,
    ) {
        parent::__construct(
            sprintf(
                "Cannot add an item with type '%s' on top of an item with type '%s'",
                $source->getDescription(),
                $pSource->getDescription(),
            ),
            400,
        );
    }
    // endregion METHOD___construct
}
// endregion CLASS_InvalidBuildStackItemException
