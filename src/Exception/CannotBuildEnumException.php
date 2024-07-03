<?php

namespace AndrewGos\ClassBuilder\Exception;

class CannotBuildEnumException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build enum from given data';
    }
}
