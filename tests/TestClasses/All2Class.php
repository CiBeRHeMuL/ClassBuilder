<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldCompareChecker;
use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

#[CanBeBuiltFromScalar]
#[BuildIf(new FieldCompareChecker('a', 1, CompareOperatorEnum::LessOrEqual))]
class All2Class extends AllClass
{
}
