<?php

namespace AndrewGos\ClassBuilder\Exception;

class InheritorsRecursionException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'possible recursion detected while checking inheritors'
            . ' (all inheritors must extends class and be not equal to checking class)';
    }
}
