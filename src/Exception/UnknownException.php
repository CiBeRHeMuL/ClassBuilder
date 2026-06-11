<?php

// GREP_SUMMARY: UnknownException, fallback wrapper, unexpected error

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use Throwable;

// region CLASS_UnknownException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Fallback wrapper for unexpected exceptions that do not implement BuildExceptionInterface, ensuring consistent error handling.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack + optional context) -> void (throws)
 * @complexity 1
 */
class UnknownException extends AbstractBuildException
{
    public function __construct(
        BuildStack $buildStack,
        protected Throwable $e,
    ) {
        parent::__construct($buildStack);
    }

    public function getCause(): string
    {
        return 'an error occurred: ' . $this->e->getMessage();
    }
}
// endregion CLASS_UnknownException
