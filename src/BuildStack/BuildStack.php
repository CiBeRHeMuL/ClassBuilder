<?php

namespace AndrewGos\ClassBuilder\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;
use AndrewGos\ClassBuilder\Exception\BuildStack\InvalidBuildStackItemException;

final class BuildStack
{
    /**
     * @var BuildStackItem[]
     */
    private array $stack = [];

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

    public function getSize(): int
    {
        return count($this->stack);
    }

    public function getLast(): BuildStackItem|null
    {
        return end($this->stack) ?: null;
    }

    public function pop(): void
    {
        if (!empty($this->stack)) {
            array_pop($this->stack);
        }
    }

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
}
