<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class SimpleClass
{
    public function __construct(
        public int $a,
        public string $b,
        public bool $c,
        public float $d,
        public array $e,
        public null $f,
    ) {
    }
}
