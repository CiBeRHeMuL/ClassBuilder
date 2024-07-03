<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;

#[AvailableInheritors([
    IntersectionClass::class,
])]
interface Intersection1Interface
{
}
