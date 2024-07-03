<?php

namespace AndrewGos\ClassBuilder\Exception;

class InvalidInheritorsException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'invalid inheritors detected (all inheritors must extends checking class)';
    }
}
