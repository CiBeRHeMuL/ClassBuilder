<?php

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use DateTime;

#[CanBeBuiltFromScalar]
class DateTimeClass
{
    public function __construct(
        private DateTime $time,
    ) {
    }
}
