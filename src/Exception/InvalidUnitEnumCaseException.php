<?php

// GREP_SUMMARY: InvalidUnitEnumCaseException, unit enum case not found

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

// region CLASS_InvalidUnitEnumCaseException [DOMAIN(8): Exception; CONCEPT(7): LeafError; TECH(7): PHP8]
/**
 * @purpose Thrown when a string value does not match any case name of a UnitEnum.
 *
 * @uses AbstractBuildException getCause()
 *
 * @io (BuildStack + optional context) -> void (throws)
 * @complexity 1
 */
class InvalidUnitEnumCaseException extends AbstractBuildException
{
    public function __construct(
        BuildStack $buildStack,
        protected string $case,
    ) {
        parent::__construct($buildStack);
    }

    public function getCause(): string
    {
        return "enum does not have case '$this->case'";
    }
}
// endregion CLASS_InvalidUnitEnumCaseException
