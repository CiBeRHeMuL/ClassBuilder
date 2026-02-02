<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class WithoutDefaultReferenceClass
{
    public function __construct(
        public ?int &$a,
    ) {}
}
