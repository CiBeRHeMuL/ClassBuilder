<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;

#[AvailableInheritors([
    SimpleInheritanceGoodChild1Class::class,
    SimpleInheritanceGoodChild2Class::class,
    SimpleInheritanceGoodChild3Class::class,
])]
class SimpleInheritanceGoodClass
{
    public function __construct(
        public string $name,
    ) {
    }
}
