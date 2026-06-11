<?php

// GREP_SUMMARY: New\TestClass, nullable, union, intersection, nested ArrayType, variadic

namespace AndrewGos\ClassBuilder\Tests\New;

use AndrewGos\ClassBuilder\Attribute\ArrayType;

// region CLASS_TestClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Comprehensive test class covering nullable, union, intersection, nested ArrayType, and variadic with ArrayType
 */
class TestClass
{
    public function __construct(
        private null $a,
        private bool $b,
        private int $c,
        private float $d,
        private string $e,
        private array $f,
        private bool|int|float|string|array|null $g,
        #[ArrayType('int')]
        private array $h,
        #[ArrayType(new ArrayType('bool'))]
        private array $i,
        private TestInheritInterface $j,
        private (Intersection1Interface&Intersection2Interface)|TestInheritInterface $k,
        #[ArrayType(TestInheritInterface::class)]
        array ...$l,
    ) {}
}
