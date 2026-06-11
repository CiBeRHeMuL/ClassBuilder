<?php

// GREP_SUMMARY: BuildStack, build path, stack data structure, validation, transition matrix
// STRUCTURE: ┌add*()┐ → validatePrevElem ┌match(pSource,source)┐ → [primitive?false] → [object|union?true] → [typedArray|variadic?subset] → ⊕ push BuildStackItem → ∑ pop → __toString ▶ traverse stack ┌match(source)┐ → render name with {-> | [...] | ...} prefix/postfix

namespace AndrewGos\ClassBuilder\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;
use AndrewGos\ClassBuilder\Exception\BuildStack\InvalidBuildStackItemException;

// region CLASS_BuildStack [DOMAIN(9): BuildStack; CONCEPT(9): StackDataStructure; TECH(8): PHP8]
final class BuildStack
{
    /**
     * @var BuildStackItem[]
     */
    private array $stack = [];

    // region METHOD_addObject [DOMAIN(9): BuildStack; CONCEPT(8): PushItem; TECH(7): Enum]
    /**
     * @purpose Push an Object-type item onto the stack after validating the transition.
     * @io string, string, string -> void
     * @complexity 2
     *
     * @param string $name     Parameter/property name
     * @param string $type     Target class FQCN
     * @param string $dataType Runtime type of the source data
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When parent item does not allow Object children
     */
    public function addObject(string $name, string $type, string $dataType): void
    {
        $this->validatePrevElem(BuildStackItemSourceEnum::Object);
        $this->stack[] = new BuildStackItem(
            BuildStackItemSourceEnum::Object,
            $name,
            $type,
            $dataType,
        );
    }
    // endregion METHOD_addObject

    // region METHOD_addTypedArray [DOMAIN(9): BuildStack; CONCEPT(8): PushItem; TECH(7): Enum]
    /**
     * @purpose Push a TypedArray-type item onto the stack after validating the transition.
     * @io string, string, string -> void
     * @complexity 2
     *
     * @param string $name     Parameter/property name
     * @param string $type     Element type FQCN
     * @param string $dataType Runtime type of the source data
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When parent item does not allow TypedArray children
     */
    public function addTypedArray(string $name, string $type, string $dataType): void
    {
        $this->validatePrevElem(BuildStackItemSourceEnum::TypedArray);
        $this->stack[] = new BuildStackItem(
            BuildStackItemSourceEnum::TypedArray,
            $name,
            $type,
            $dataType,
        );
    }
    // endregion METHOD_addTypedArray

    // region METHOD_addUnion [DOMAIN(9): BuildStack; CONCEPT(8): PushItem; TECH(7): Enum]
    /**
     * @purpose Push a Union-type item onto the stack after validating the transition.
     * @io string, string, string -> void
     * @complexity 2
     *
     * @param string $name     Parameter/property name
     * @param string $type     Union type descriptor
     * @param string $dataType Runtime type of the source data
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When parent item does not allow Union children
     */
    public function addUnion(string $name, string $type, string $dataType): void
    {
        $this->validatePrevElem(BuildStackItemSourceEnum::Union);
        $this->stack[] = new BuildStackItem(
            BuildStackItemSourceEnum::Union,
            $name,
            $type,
            $dataType,
        );
    }
    // endregion METHOD_addUnion

    // region METHOD_addVariadic [DOMAIN(9): BuildStack; CONCEPT(8): PushItem; TECH(7): Enum]
    /**
     * @purpose Push a Variadic-type item onto the stack after validating the transition.
     * @io string, string, string -> void
     * @complexity 2
     *
     * @param string $name     Parameter/property name
     * @param string $type     Variadic parameter type
     * @param string $dataType Runtime type of the source data
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When parent item does not allow Variadic children
     */
    public function addVariadic(string $name, string $type, string $dataType): void
    {
        $this->validatePrevElem(BuildStackItemSourceEnum::Variadic);
        $this->stack[] = new BuildStackItem(
            BuildStackItemSourceEnum::Variadic,
            $name,
            $type,
            $dataType,
        );
    }
    // endregion METHOD_addVariadic

    // region METHOD_addPrimitive [DOMAIN(9): BuildStack; CONCEPT(8): PushItem; TECH(7): Enum]
    /**
     * @purpose Push a Primitive-type item onto the stack after validating the transition.
     * @io string, string, string -> void
     * @complexity 2
     *
     * @param string $name     Parameter/property name
     * @param string $type     Primitive type name
     * @param string $dataType Runtime type of the source data
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When parent item does not allow Primitive children
     */
    public function addPrimitive(string $name, string $type, string $dataType): void
    {
        $this->validatePrevElem(BuildStackItemSourceEnum::Primitive);
        $this->stack[] = new BuildStackItem(
            BuildStackItemSourceEnum::Primitive,
            $name,
            $type,
            $dataType,
        );
    }
    // endregion METHOD_addPrimitive

    // region METHOD_getSize [DOMAIN(9): BuildStack; CONCEPT(7): Query; TECH(7): PHP8]
    /**
     * @purpose Return the current number of items on the stack.
     * @io -> int
     * @complexity 1
     *
     * @return int Stack depth
     */
    public function getSize(): int
    {
        return count($this->stack);
    }
    // endregion METHOD_getSize

    // region METHOD_getLast [DOMAIN(9): BuildStack; CONCEPT(7): Query; TECH(7): PHP8]
    /**
     * @purpose Return the top item without removing it, or null for an empty stack.
     * @io -> BuildStackItem|null
     * @complexity 1
     *
     * @return BuildStackItem|null Top item or null
     */
    public function getLast(): ?BuildStackItem
    {
        return end($this->stack) ?: null;
    }
    // endregion METHOD_getLast

    // region METHOD_pop [DOMAIN(9): BuildStack; CONCEPT(7): Mutator; TECH(7): PHP8]
    /**
     * @purpose Remove the top item from the stack; safe to call on empty stack.
     * @io -> void
     * @complexity 1
     *
     * @return void
     */
    public function pop(): void
    {
        if (!empty($this->stack)) {
            array_pop($this->stack);
        }
    }
    // endregion METHOD_pop

    // region METHOD___toString [DOMAIN(9): BuildStack; CONCEPT(9): Render; TECH(8): Stringable]
    /**
     * @purpose Render the full build path as a human-readable string with ->, [...], and ... prefixes.
     * @io -> string
     * @complexity 4
     *
     * @return string Formatted path (e.g. "root->items[0]->name")
     */
    public function __toString(): string
    {
        $prefix = '';
        $postfix = '';
        $result = '';
        foreach ($this->stack as $item) {
            if ($item->getSource() === BuildStackItemSourceEnum::Object) {
                $result .= $prefix . $item->getName() . $postfix;
                $prefix = '->';
                $postfix = '';
            } elseif ($item->getSource() === BuildStackItemSourceEnum::TypedArray) {
                $result .= $prefix . $item->getName() . $postfix;
                $prefix = '[';
                $postfix = ']';
            } elseif ($item->getSource() === BuildStackItemSourceEnum::Variadic) {
                $result .= $prefix . '...' . $item->getName() . $postfix;
                $prefix = '';
                $postfix = '';
            } else {
                $result .= $prefix . $item->getName() . $postfix;
            }
        }

        return $result;
    }
    // endregion METHOD___toString

    // region METHOD_validatePrevElem [DOMAIN(9): BuildStack; CONCEPT(9): TransitionValidation; TECH(8): MatchExpression]
    /**
     * @purpose Validate that the new item source type is compatible with the current top-of-stack source type per transition matrix.
     * @io BuildStackItemSourceEnum -> void
     * @complexity 4
     *
     * @param BuildStackItemSourceEnum $source Source type to validate
     *
     * @return void
     *
     * @throws InvalidBuildStackItemException When transition is not allowed
     */
    private function validatePrevElem(BuildStackItemSourceEnum $source): void
    {
        if (!empty($this->stack)) {
            $parent = end($this->stack);
            $pSource = $parent->getSource();
            $canBeAdded = match ($pSource) {
                BuildStackItemSourceEnum::Primitive => false,
                BuildStackItemSourceEnum::Object, BuildStackItemSourceEnum::Union => true,
                BuildStackItemSourceEnum::TypedArray, BuildStackItemSourceEnum::Variadic => in_array(
                    $source,
                    [
                        BuildStackItemSourceEnum::Primitive,
                        BuildStackItemSourceEnum::Object,
                        BuildStackItemSourceEnum::TypedArray,
                        BuildStackItemSourceEnum::Union,
                    ],
                    true,
                ),
            };
            if (!$canBeAdded) {
                throw new InvalidBuildStackItemException($pSource, $source);
            }
        }
    }
    // endregion METHOD_validatePrevElem
}
// endregion CLASS_BuildStack
