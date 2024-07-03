<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;

#[AvailableInheritors([
    TestInheritInterface1::class,
    TestInheritInterface2::class,
])]
interface TestInheritInterface
{
}
