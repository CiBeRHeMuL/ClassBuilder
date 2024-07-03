<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use Throwable;

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
