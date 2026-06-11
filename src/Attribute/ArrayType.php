<?php

// GREP_SUMMARY: ArrayType, attribute, element type, typed array, nested array, stringable
// STRUCTURE: ┌construct(type:string|string[]|ArrayType)┐ → getType → __toString ▶ implode((array)type,'|') . '[]'

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;
use Stringable;

// region CLASS_ArrayType [DOMAIN(8): Attributes; CONCEPT(8): TypeMapping; TECH(8): PHP8Attribute]
/**
 * @purpose Specifies the element type for array parameters, supporting nesting via recursive ArrayType.
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
readonly class ArrayType implements Stringable
{
    // region METHOD___construct [DOMAIN(8): Attributes; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Initialize with element type (primitive, union, or nested ArrayType).
     * @io string|string[]|ArrayType -> void
     * @complexity 1
     *
     * @param string|string[]|ArrayType $type Element type descriptor
     */
    public function __construct(
        private string|array|ArrayType $type,
    ) {}
    // endregion METHOD___construct

    // region METHOD_getType [DOMAIN(8): Attributes; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the element type descriptor.
     * @io -> ArrayType|array|string
     * @complexity 1
     *
     * @return ArrayType|array|string Element type
     */
    public function getType(): ArrayType|array|string
    {
        return $this->type;
    }
    // endregion METHOD_getType

    // region METHOD___toString [DOMAIN(8): Attributes; CONCEPT(7): Render; TECH(7): Stringable]
    /**
     * @purpose Render as "(type)[]" string for debugging and error messages.
     * @io -> string
     * @complexity 1
     *
     * @return string String representation
     */
    public function __toString(): string
    {
        return '(' . implode('|', (array) $this->type) . ')[]';
    }
    // endregion METHOD___toString
}
// endregion CLASS_ArrayType
