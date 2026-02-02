<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class WithDefaultReferenceClass
{
    public function __construct(
        public ?int &$a = null,
    ) {}
}
