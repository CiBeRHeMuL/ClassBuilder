<?php

// GREP_SUMMARY: TestClasses\SimpleInheritanceGoodChild3Class, inheritance, BuildIf, extra parameter

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

// region CLASS_SimpleInheritanceGoodChild3Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete child 3 for SimpleInheritanceGoodClass (extra 'age' parameter)
 */
#[BuildIf(new FieldIsChecker('name', '3'))]
class SimpleInheritanceGoodChild3Class extends SimpleInheritanceGoodClass
{
    public function __construct(
        string $name,
        public int $age,
    ) {
        parent::__construct($name);
    }
}
