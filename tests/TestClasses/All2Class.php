<?php

// GREP_SUMMARY: TestClasses\All2Class, inheritance, BuildIf, FieldCompareChecker, scalar

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldCompareChecker;
use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

// region CLASS_All2Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete child for AllClass: requires 'a' = 0 via FieldIsChecker
 */
#[CanBeBuiltFromScalar]
#[BuildIf(new FieldCompareChecker('a', 1, CompareOperatorEnum::LessOrEqual))]
class All2Class extends AllClass {}
