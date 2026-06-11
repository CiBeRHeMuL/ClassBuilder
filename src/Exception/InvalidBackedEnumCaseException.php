<?php

// GREP_SUMMARY: InvalidBackedEnumCaseException, backed enum case not found

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

// region CLASS_InvalidBackedEnumCaseException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a value does not match any case of a BackedEnum (enum::from() failure).
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack + optional context) -> void (throws)
 * @complexity 1
 */
class InvalidBackedEnumCaseException extends AbstractBuildException
{
    public function __construct(
        BuildStack $buildStack,
        protected string|int $case,
    ) {
        parent::__construct($buildStack);
    }

    public function getCause(): string
    {
        return "enum does not have case with backing value '$this->case'";
    }
}
// endregion CLASS_InvalidBackedEnumCaseException
