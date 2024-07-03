<?php

namespace AndrewGos\ClassBuilder\Exception;

class BuildTypeNotFoundException extends AbstractBuildException
{
    public function getCause(): string
    {
        return 'cannot find types to build parameter';
    }
}
