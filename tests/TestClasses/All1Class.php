<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\ArrayType;
use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldCompareChecker;
use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

#[BuildIf(new FieldCompareChecker('a', 1, CompareOperatorEnum::Greater))]
class All1Class extends AllClass
{
    public function __construct(
        int $a,
        #[ArrayType(AllClass::class)] public array $b,
        #[ArrayType(SimpleScalarClass::class)] public array $c,
    ) {
        parent::__construct($a);
    }
}
