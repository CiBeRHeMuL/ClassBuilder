<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

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
