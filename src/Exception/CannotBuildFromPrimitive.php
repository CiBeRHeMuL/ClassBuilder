<?php

namespace AndrewGos\ClassBuilder\Exception;

class CannotBuildFromPrimitive extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot build value from primitive data';
    }
}
