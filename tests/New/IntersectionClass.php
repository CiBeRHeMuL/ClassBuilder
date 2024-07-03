<?php

namespace AndrewGos\ClassBuilder\Tests\New;

class IntersectionClass implements Intersection1Interface, Intersection2Interface
{
    public function __construct(
        private int $a,
    ) {
    }
}
