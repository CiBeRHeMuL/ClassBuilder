<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\BuildIf;
use AndrewGos\ClassBuilder\Attributes\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

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
