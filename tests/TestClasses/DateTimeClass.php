<?php

// GREP_SUMMARY: TestClasses\DateTimeClass, DateTime, DateTimeImmutable, scalar construction

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use DateTime;

// region CLASS_DateTimeClass [DOMAIN(6): Testing; CONCEPT(6): TestFixture; TECH(6): PHP8]
/**
 * @purpose Test class with DateTime/DateTimeImmutable constructor parameters
 */
#[CanBeBuiltFromScalar]
class DateTimeClass
{
    public function __construct(
        private DateTime $time,
    ) {}
}
