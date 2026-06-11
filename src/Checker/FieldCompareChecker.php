<?php

// GREP_SUMMARY: FieldCompareChecker, field comparison, operator, data validation
// STRUCTURE: ┌construct(field,compareValue,operator)┐ → check(data) ▶ extract data[field] → match(operator) → {==,===,!=,!==,>,>=,<,<=} → bool

namespace AndrewGos\ClassBuilder\Checker;

use AndrewGos\ClassBuilder\Enum\CompareOperatorEnum;

// region CLASS_FieldCompareChecker [DOMAIN(8): Checker; CONCEPT(8): FieldComparison; TECH(8): MatchExpression]
/**
 * @purpose Compares a named field from input data against a reference value using a configurable comparison operator (enum).
 */
readonly class FieldCompareChecker implements CheckerInterface
{
    // region METHOD___construct [DOMAIN(8): Checker; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Set the field name, reference value, and comparison operator.
     * @io string|int, mixed, CompareOperatorEnum -> void
     * @complexity 1
     *
     * @param string|int          $field        Data array key to check
     * @param mixed               $compareValue Reference value for comparison
     * @param CompareOperatorEnum $operator     Comparison operator
     */
    public function __construct(
        private string|int $field,
        private mixed $compareValue,
        private CompareOperatorEnum $operator,
    ) {}
    // endregion METHOD___construct

    // region METHOD_check [DOMAIN(8): Checker; CONCEPT(8): FieldComparison; TECH(8): MatchExpression]
    /**
     * @purpose Perform the configured comparison between data field and reference value.
     * @io mixed -> bool
     * @complexity 3
     *
     * @param mixed $data Input data (typically array)
     *
     * @return bool Comparison result
     */
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
    // endregion METHOD_check
}
// endregion CLASS_FieldCompareChecker
