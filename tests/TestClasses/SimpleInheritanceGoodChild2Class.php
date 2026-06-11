<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceGoodChild2Class, inheritance, BuildIf, FieldIsChecker

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

// region CLASS_SimpleInheritanceGoodChild2Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete child 2 for SimpleInheritanceGoodClass (matching name='2')
 */
#[CanBeBuiltFromScalar]
#[BuildIf(new FieldIsChecker('name', '2'))]
class SimpleInheritanceGoodChild2Class extends SimpleInheritanceGoodClass
{
    public function __construct(
        string $name,
    ) {
        parent::__construct($name);
    }
}
