<?php

declare(strict_types=1);

// GREP_SUMMARY: TestClasses\RecursiveTypeClass, self-referencing, recursive type, string|array|RecursiveTypeClass

namespace AndrewGos\ClassBuilder\Tests\TestClasses;

use AndrewGos\ClassBuilder\Attribute\ArrayType;

// region CLASS_RecursiveTypeClass [DOMAIN(6): Testing; CONCEPT(7): RecursiveTypeFixture; TECH(6): PHP8]
/**
 * @purpose Test fixture with self-referencing union type string|array|RecursiveTypeClass and ArrayType attribute — used to verify no infinite recursion.
 */
class RecursiveTypeClass
{
    public function __construct(
        #[ArrayType([RecursiveTypeClass::class, 'string'])]
        public string|array|RecursiveTypeClass $a,
    ) {}
}
// endregion CLASS_RecursiveTypeClass
