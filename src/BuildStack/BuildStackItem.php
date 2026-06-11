<?php

// GREP_SUMMARY: BuildStackItem, value object, stack entry, source enum, type pretty print
// STRUCTURE: ┌construct(source,name,type,dataType)┐ → readonly properties → getTypePretty ▶ match(source) ┌Primitive|Union|Object→type┐ ┌TypedArray→type[]┐ ┌Variadic→...type┐

namespace AndrewGos\ClassBuilder\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;

// region CLASS_BuildStackItem [DOMAIN(9): BuildStack; CONCEPT(8): ValueObject; TECH(7): PHP8Readonly]
/**
 * @purpose Immutable value object representing one frame in the BuildStack with source type, name, type, data type, and pretty-print support.
 */
final readonly class BuildStackItem
{
    // region METHOD___construct [DOMAIN(9): BuildStack; CONCEPT(7): Init; TECH(7): PHP8ConstructorPromotion]
    /**
     * @purpose Initialize an immutable stack frame with source, name, type, and data type.
     * @io BuildStackItemSourceEnum, string, string, string -> void
     * @complexity 1
     *
     * @param BuildStackItemSourceEnum $source   Origin of this stack entry
     * @param string                   $name     Parameter or key name
     * @param string                   $type     Expected type (FQCN or primitive name)
     * @param string                   $dataType Actual runtime type of the data
     */
    public function __construct(
        private BuildStackItemSourceEnum $source,
        private string $name,
        private string $type,
        private string $dataType,
    ) {}
    // endregion METHOD___construct

    // region METHOD_getSource [DOMAIN(9): BuildStack; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the source type classification of this stack entry.
     * @io -> BuildStackItemSourceEnum
     * @complexity 1
     *
     * @return BuildStackItemSourceEnum Source type
     */
    public function getSource(): BuildStackItemSourceEnum
    {
        return $this->source;
    }
    // endregion METHOD_getSource

    // region METHOD_getName [DOMAIN(9): BuildStack; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the parameter or key name associated with this stack entry.
     * @io -> string
     * @complexity 1
     *
     * @return string Name identifier
     */
    public function getName(): string
    {
        return $this->name;
    }
    // endregion METHOD_getName

    // region METHOD_getType [DOMAIN(9): BuildStack; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the expected type (FQCN or primitive name) of this stack entry.
     * @io -> string
     * @complexity 1
     *
     * @return string Type name
     */
    public function getType(): string
    {
        return $this->type;
    }
    // endregion METHOD_getType

    // region METHOD_getDataType [DOMAIN(9): BuildStack; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the actual runtime type of the data being built for this stack entry.
     * @io -> string
     * @complexity 1
     *
     * @return string Data type name (from get_debug_type)
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }
    // endregion METHOD_getDataType

    // region METHOD_getTypePretty [DOMAIN(9): BuildStack; CONCEPT(7): Render; TECH(7): MatchExpression]
    /**
     * @purpose Render the type in a human-readable format (e.g. "int[]", "...string", or plain type name).
     * @io -> string
     * @complexity 2
     *
     * @return string Pretty-printed type representation
     */
    public function getTypePretty(): string
    {
        return match ($this->source) {
            BuildStackItemSourceEnum::Primitive, BuildStackItemSourceEnum::Union, BuildStackItemSourceEnum::Object => $this->type,
            BuildStackItemSourceEnum::TypedArray => "{$this->type}[]",
            BuildStackItemSourceEnum::Variadic => "...$this->type",
        };
    }
    // endregion METHOD_getTypePretty
}
// endregion CLASS_BuildStackItem
