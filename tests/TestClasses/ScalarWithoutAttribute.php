<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class ScalarWithoutAttribute
{
    public function __construct(
        public string $a,
    ) {
    }
}
