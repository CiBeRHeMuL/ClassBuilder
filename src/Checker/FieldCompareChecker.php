<?php

namespace AndrewGos\ClassBuilder\Checker;

use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

readonly class FieldCompareChecker implements CheckerInterface
{
    public function __construct(
        private string|int $field,
        private mixed $compareValue,
        private CompareOperatorEnum $operator,
    ) {
    }

    public function check(mixed $data): bool
    {
        $value = $data[$this->field] ?? null;
        return match ($this->operator) {
            CompareOperatorEnum::Equal => $value == $this->compareValue,
            CompareOperatorEnum::StrictEqual => $value === $this->compareValue,
            CompareOperatorEnum::NotEqual => $value != $this->compareValue,
            CompareOperatorEnum::StrictNotEqual => $value !== $this->compareValue,
            CompareOperatorEnum::Greater => $value > $this->compareValue,
            CompareOperatorEnum::GreaterOrEqual => $value >= $this->compareValue,
            CompareOperatorEnum::Less => $value < $this->compareValue,
            CompareOperatorEnum::LessOrEqual => $value <= $this->compareValue,
        };
    }
}
