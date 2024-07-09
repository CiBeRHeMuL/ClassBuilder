<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\Exception\AbstractBuildException;

class ValueNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'value not found';
    }
}
