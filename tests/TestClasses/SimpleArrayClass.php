<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\ArrayType;

class SimpleArrayClass
{
    public function __construct(
        #[ArrayType(['int', 'string', 'bool', 'float', 'null'])] public array $a,
        #[ArrayType(new ArrayType(['int', 'string', 'bool', 'float', 'null']))] public array $b,
    ) {
    }
}