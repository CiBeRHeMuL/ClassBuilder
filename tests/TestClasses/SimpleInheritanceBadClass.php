<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

#[AvailableInheritors([SimpleInheritanceBadClass::class])]
class SimpleInheritanceBadClass
{
    public function __construct(
        string $name,
    ) {
    }
}
