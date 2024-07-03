<?php

namespace AndrewGos\ClassBuilder\Checker;

readonly class FieldIsChecker implements CheckerInterface
{
    public function __construct(
        private string|int $field,
        private mixed $equalTo,
        private bool $strict = true,
    ) {
    }

    public function check(mixed $data): bool
    {
        $value = $data[$this->field] ?? null;
        return $this->strict ? ($value === $this->equalTo) : ($value == $this->equalTo);
    }
}
