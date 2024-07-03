<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

interface BuildExceptionInterface
{
    public function getBuildStack(): BuildStack;

    public function getCause(): string;
}
