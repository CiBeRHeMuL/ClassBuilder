<?php

namespace AndrewGos\ClassBuilder\Enum\BuildStack;

enum BuildStackItemSourceEnum
{
    case Primitive;
    case Object;
    case TypedArray;
    case Variadic;
    case Union;

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
}
