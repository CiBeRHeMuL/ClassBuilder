<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceGoodClass, inheritance, AvailableInheritors, abstract

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_SimpleInheritanceGoodClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Abstract test class with valid AvailableInheritors (3 concrete children)
 */
#[AvailableInheritors([
    SimpleInheritanceGoodChild1Class::class,
    SimpleInheritanceGoodChild2Class::class,
    SimpleInheritanceGoodChild3Class::class,
])]
class SimpleInheritanceGoodClass
{
    public function __construct(
        public string $name,
    ) {}
}
