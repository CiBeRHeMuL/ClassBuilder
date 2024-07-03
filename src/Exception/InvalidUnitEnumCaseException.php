<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

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
