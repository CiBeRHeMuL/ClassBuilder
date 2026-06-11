<?php

// GREP_SUMMARY: TestClasses\AllClass, inheritance, AvailableInheritors, abstract, BuildIf

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;

// region CLASS_AllClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Abstract test class with multiple inheritors (All1Class, All2Class) selected via BuildIf
 */
#[AvailableInheritors([
    All1Class::class,
    All2Class::class,
])]
abstract class AllClass
{
    public function __construct(
        public int $a,
    ) {}
}
