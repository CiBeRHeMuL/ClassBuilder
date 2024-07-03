<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

class SimpleDefaultValueClass
{
    public function __construct(
        public int $a = 1,
        public string $b = 'asdf',
        public bool $c = false,
        public float $d = 1.1234,
        public array $e = [1, 23],
        public null $f = null,
    ) {
    }
}
