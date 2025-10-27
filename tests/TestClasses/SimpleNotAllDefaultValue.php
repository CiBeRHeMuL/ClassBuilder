<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class SimpleNotAllDefaultValue
{
    public function __construct(
        public int $a,
        public string $b,
        public bool $c,
        public float $d,
        public array $e = [1, 2],
        public null $f = null,
    ) {
    }
}
