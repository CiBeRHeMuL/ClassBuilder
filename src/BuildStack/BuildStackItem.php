<?php

namespace AndrewGos\ClassBuilder\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;

final readonly class BuildStackItem
{
    public function __construct(
        private BuildStackItemSourceEnum $source,
        private string $name,
        private string $type,
        private string $dataType,
    ) {
    }

    public function getSource(): BuildStackItemSourceEnum
    {
        return $this->source;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function getTypePretty(): string
    {
        return match ($this->source) {
            BuildStackItemSourceEnum::Primitive, BuildStackItemSourceEnum::Union, BuildStackItemSourceEnum::Object => $this->type,
            BuildStackItemSourceEnum::TypedArray => "{$this->type}[]",
            BuildStackItemSourceEnum::Variadic => "...$this->type",
        };
    }
}
