<?php

namespace AndrewGos\ClassBuilder\Exception;

class CannotBuildReferenceException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build referenced parameter';
    }
}
