<?php

namespace AndrewGos\ClassBuilder\Exception;

class EnumNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'enum not found';
    }
}
