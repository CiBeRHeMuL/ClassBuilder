<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

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
