<?php

// GREP_SUMMARY: New\TestInheritInterface2, inheritance, BuildIf, FieldIsChecker

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

// region CLASS_TestInheritInterface2 [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Second inheritor of TestInheritInterface
 */
#[BuildIf(new FieldIsChecker('a', 2))]
class TestInheritInterface2 implements TestInheritInterface
{
    public function __construct(
        private int $a,
        private TestInheritInterface $b,
    ) {}
}
