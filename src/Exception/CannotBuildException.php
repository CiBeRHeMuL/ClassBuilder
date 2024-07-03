<?php

namespace AndrewGos\ClassBuilder\Exception;

class CannotBuildException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build value from given data';
    }
}
