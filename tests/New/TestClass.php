<?php

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attributes\ArrayType;

class TestClass
{
    public function __construct(
        private null $a,
        private bool $b,
        private int $c,
        private float $d,
        private string $e,
        private array $f,
        private null|bool|int|float|string|array $g,
        #[ArrayType('int')] private array $h,
        #[ArrayType(new ArrayType('bool'))] private array $i,
        private TestInheritInterface $j,
        private (Intersection1Interface&Intersection2Interface)|TestInheritInterface $k,
        #[ArrayType(TestInheritInterface::class)] array ...$l,
    ) {
    }
}
