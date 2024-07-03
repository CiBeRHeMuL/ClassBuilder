<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

#[AvailableInheritors([SimpleScalarClass::class])]
class SimpleInheritanceBad1Class
{
    public function __construct(
        string $name,
    ) {
    }
}
