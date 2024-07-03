<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attributes\ArrayType;

class ArrayClass
{
    public function __construct(
        public string $a,
        #[ArrayType(SimpleScalarClass::class)] public array $b,
    ) {
    }
}
