<?php

// GREP_SUMMARY: Field, attribute, field mapping, data key override
// STRUCTURE: ┌construct(field:string)┐ → getField → return field name

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;

// region CLASS_Field [DOMAIN(8): Attributes; CONCEPT(7): FieldMapping; TECH(7): PHP8Attribute]
/**
 * @purpose Overrides the data array key used to populate a constructor parameter, decoupling parameter name from data field name.
 */
#[Attribute]
class Field
{
    // region METHOD___construct [DOMAIN(8): Attributes; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Set the custom field name for data lookup.
     * @io string -> void
     * @complexity 1
     *
     * @param string $field Data array key to use
     */
    public function __construct(
        protected string $field,
    ) {}
    // endregion METHOD___construct

    // region METHOD_getField [DOMAIN(8): Attributes; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the configured data field name.
     * @io -> string
     * @complexity 1
     *
     * @return string Field name
     */
    public function getField(): string
    {
        return $this->field;
    }
    // endregion METHOD_getField
}
// endregion CLASS_Field
