<?php

// GREP_SUMMARY: AndChecker, composite checker, logical AND, checkers aggregation
// STRUCTURE: ┌construct(checkers:CheckerInterface[])┐ → check(data) ▶ loop all checkers → [any false?] → return false → ∑ return true

namespace AndrewGos\ClassBuilder\Checker;

// region CLASS_AndChecker [DOMAIN(8): Checker; CONCEPT(8): CompositeChecker; TECH(7): PHP8]
/**
 * @purpose Composite checker that performs a logical AND over multiple CheckerInterface instances. All must pass for check() to return true.
 */
readonly class AndChecker implements CheckerInterface
{
    // region METHOD___construct [DOMAIN(8): Checker; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Register the list of checkers to aggregate.
     * @io CheckerInterface[] -> void
     * @complexity 1
     *
     * @param CheckerInterface[] $checkers Ordered list of checkers
     */
    public function __construct(
        private array $checkers,
    ) {}
    // endregion METHOD___construct

    // region METHOD_check [DOMAIN(8): Checker; CONCEPT(8): CompositeValidation; TECH(7): PHP8]
    /**
     * @purpose Run all registered checkers; return false immediately on first failure.
     * @io mixed -> bool
     * @complexity 2
     *
     * @param mixed $data Data to validate
     *
     * @return bool True if all checkers pass
     */
    public function check(mixed $data): bool
    {
        foreach ($this->checkers as $checker) {
            if (!$checker->check($data)) {
                return false;
            }
        }

        return true;
    }
    // endregion METHOD_check
}
// endregion CLASS_AndChecker
