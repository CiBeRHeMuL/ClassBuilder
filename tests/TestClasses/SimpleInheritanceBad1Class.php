<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;

#[AvailableInheritors([SimpleScalarClass::class])]
class SimpleInheritanceBad1Class
{
    public function __construct(
        string $name,
    ) {
    }
}
