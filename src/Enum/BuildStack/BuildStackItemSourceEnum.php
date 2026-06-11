<?php

// GREP_SUMMARY: BuildStackItemSourceEnum, source enum, stack item types, unit enum, description
// STRUCTURE: cases: Primitive, Object, TypedArray, Variadic, Union → getDescription ┌match(case)┐ → human-readable string

namespace AndrewGos\ClassBuilder\Enum\BuildStack;

// region CLASS_BuildStackItemSourceEnum [DOMAIN(8): Enum; CONCEPT(8): SourceTypes; TECH(7): PHP8UnitEnum]
/**
 * @purpose Unit enumeration of BuildStackItem source types, used for transition validation and human-readable path rendering.
 */
enum BuildStackItemSourceEnum
{
    case Primitive;
    case Object;
    case TypedArray;
    case Variadic;
    case Union;

    // region METHOD_getDescription [DOMAIN(8): Enum; CONCEPT(7): Render; TECH(7): MatchExpression]
    /**
     * @purpose Get a human-readable description of this source type for error messages.
     * @io -> string
     * @complexity 1
     *
     * @return string Description string
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::Primitive => 'null|bool|int|float|string|array',
            self::Object => 'object',
            self::TypedArray => 'typed array',
            self::Variadic => 'variadic',
            self::Union => 'union',
        };
    }
    // endregion METHOD_getDescription
}
// endregion CLASS_BuildStackItemSourceEnum
