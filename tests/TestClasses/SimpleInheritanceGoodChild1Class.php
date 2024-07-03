<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

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
