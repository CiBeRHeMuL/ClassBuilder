<?php

// GREP_SUMMARY: BuildIf, attribute, conditional build, checker, condition
// STRUCTURE: ┌construct(checker:CheckerInterface)┐ → getChecker → return checker

namespace AndrewGos\ClassBuilder\Attribute;

use AndrewGos\ClassBuilder\Checker\CheckerInterface;
use Attribute;

// region CLASS_BuildIf [DOMAIN(8): Attributes; CONCEPT(8): ConditionalConstruction; TECH(7): PHP8Attribute]
/**
 * @purpose Attaches a runtime condition (CheckerInterface) that must pass for the class to be constructed, enabling conditional object building.
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class BuildIf
{
    // region METHOD___construct [DOMAIN(8): Attributes; CONCEPT(7): Init; TECH(7): PHP8]
    /**
     * @purpose Set the checker instance that will validate data before construction.
     * @io CheckerInterface -> void
     * @complexity 1
     *
     * @param CheckerInterface $checker Condition checker
     */
    public function __construct(
        private CheckerInterface $checker,
    ) {}
    // endregion METHOD___construct

    // region METHOD_getChecker [DOMAIN(8): Attributes; CONCEPT(7): Accessor; TECH(7): PHP8]
    /**
     * @purpose Get the configured checker instance.
     * @io -> CheckerInterface
     * @complexity 1
     *
     * @return CheckerInterface Condition checker
     */
    public function getChecker(): CheckerInterface
    {
        return $this->checker;
    }
    // endregion METHOD_getChecker
}
// endregion CLASS_BuildIf
