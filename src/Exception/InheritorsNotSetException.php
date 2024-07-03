<?php

namespace AndrewGos\ClassBuilder\Exception;

class InheritorsNotSetException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'inheritors not set';
    }
}
