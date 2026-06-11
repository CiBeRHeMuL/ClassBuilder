<?php

// GREP_SUMMARY: FieldIsChecker, field equality, strict comparison, data validation
// STRUCTURE: ┌construct(field,equalTo,strict)┐ → check(data) ▶ extract data[field] → {=== | ==} equalTo → bool

namespace AndrewGos\ClassBuilder\Checker;

// region CLASS_FieldIsChecker [DOMAIN(8): Checker; CONCEPT(7): FieldEquality; TECH(7): PHP8]
/**
 * @purpose Checks whether a named data field equals a reference value, with optional strict (===) or loose (==) comparison.
 */
readonly class FieldIsChecker implements CheckerInterface
{
    // region METHOD___construct [DOMAIN(8): Checker; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Set the field name, reference value, and strictness flag.
     * @io string|int, mixed, bool -> void
     * @complexity 1
     *
     * @param string|int $field   Data array key to check
     * @param mixed      $equalTo Reference value
     * @param bool       $strict  Use strict comparison (===) when true
     */
    public function __construct(
        private string|int $field,
        private mixed $equalTo,
        private bool $strict = true,
    ) {}
    // endregion METHOD___construct

    // region METHOD_check [DOMAIN(8): Checker; CONCEPT(7): FieldEquality; TECH(7): PHP8]
    /**
     * @purpose Compare the data field value against the reference using configured strictness.
     * @io mixed -> bool
     * @complexity 2
     *
     * @param mixed $data Input data (typically array)
     *
     * @return bool True if values match
     */
    public function check(mixed $data): bool
    {
        $value = $data[$this->field] ?? null;

        return $this->strict ? ($value === $this->equalTo) : ($value == $this->equalTo);
    }
    // endregion METHOD_check
}
// endregion CLASS_FieldIsChecker
