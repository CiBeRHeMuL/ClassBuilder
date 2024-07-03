<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

#[AvailableInheritors([
    All1Class::class,
    All2Class::class,
])]
abstract class AllClass
{
    public function __construct(
        public int $a,
    ) {
    }
}
