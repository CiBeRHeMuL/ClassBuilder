<?php

// GREP_SUMMARY: CheckerInterface, data validation, condition check, BuildIf
// STRUCTURE: ┌check(data: mixed) → bool┐

namespace AndrewGos\ClassBuilder\Checker;

// region CLASS_CheckerInterface [DOMAIN(8): Checker; CONCEPT(8): ValidationContract; TECH(7): PHP8]
/**
 * @purpose Contract for data validation checks used by BuildIf attribute. Implementations inspect data and return boolean pass/fail.
 * @io mixed -> bool
 * @complexity 1
 *
 * @param mixed $data Data to validate
 *
 * @return bool True if data passes the check
 */
interface CheckerInterface
{
    public function check(mixed $data): bool;
}
// endregion CLASS_CheckerInterface
