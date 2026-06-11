<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceGoodChild1Class, inheritance, BuildIf, FieldIsChecker

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

// region CLASS_SimpleInheritanceGoodChild1Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete child 1 for SimpleInheritanceGoodClass (matching name='1')
 */
#[CanBeBuiltFromScalar]
#[BuildIf(new FieldIsChecker('name', '1'))]
class SimpleInheritanceGoodChild1Class extends SimpleInheritanceGoodClass
{
    public function __construct(
        string $name,
    ) {
        parent::__construct($name);
    }
}
