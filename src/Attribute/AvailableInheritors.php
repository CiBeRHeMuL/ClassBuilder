<?php

// GREP_SUMMARY: AvailableInheritors, attribute, polymorphism, inheritors, concrete classes
// STRUCTURE: ┌construct(inheritors:class-string[])┐ → getInheritors → return array

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;

// region CLASS_AvailableInheritors [DOMAIN(8): Attributes; CONCEPT(8): Polymorphism; TECH(7): PHP8Attribute]
/**
 * @purpose Lists concrete classes that can be instantiated in place of an abstract class or interface, enabling polymorphic deserialization.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
readonly class AvailableInheritors
{
    // region METHOD___construct [DOMAIN(8): Attributes; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Register the list of valid inheritor class names.
     * @io class-string[] -> void
     * @complexity 1
     *
     * @param class-string[] $inheritors FQCNs of concrete subclasses
     */
    public function __construct(
        private array $inheritors = [],
    ) {}
    // endregion METHOD___construct

    // region METHOD_getInheritors [DOMAIN(8): Attributes; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the registered inheritor class names.
     * @io -> class-string[]
     * @complexity 1
     *
     * @return class-string[] FQCNs of concrete subclasses
     */
    public function getInheritors(): array
    {
        return $this->inheritors;
    }
    // endregion METHOD_getInheritors
}
// endregion CLASS_AvailableInheritors
