<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class TestNull
{
    public function __construct(
        private ?int $a,
    ) {
    }
}
