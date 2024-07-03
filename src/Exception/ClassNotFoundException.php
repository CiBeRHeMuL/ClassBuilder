<?php

namespace AndrewGos\ClassBuilder\Exception;

class ClassNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'class not found';
    }
}
