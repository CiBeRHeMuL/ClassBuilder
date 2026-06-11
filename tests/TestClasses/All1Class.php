<?php

// GREP_SUMMARY: TestClasses\All1Class, inheritance, BuildIf, FieldCompareChecker, ArrayType

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\ArrayType;
use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldCompareChecker;
use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

// region CLASS_All1Class [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Concrete child for AllClass: requires 'a' field presence for BuildIf match
 */
#[BuildIf(new FieldCompareChecker('a', 1, CompareOperatorEnum::Greater))]
class All1Class extends AllClass
{
    public function __construct(
        int $a,
        #[ArrayType(AllClass::class)]
        public array $b,
        #[ArrayType(SimpleScalarClass::class)]
        public array $c,
    ) {
        parent::__construct($a);
    }
}
