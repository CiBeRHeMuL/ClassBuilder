<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

#[AvailableInheritors([
    IntersectionClass::class,
])]
interface Intersection1Interface
{
}
