<?php

// GREP_SUMMARY: BuildExceptionInterface, exception contract, getBuildStack, getCause

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;

// region INTERFACE_BuildExceptionInterface [DOMAIN(8): Exception; CONCEPT(8): Contract; TECH(7): PHP8]
/**
 * @purpose Contract for all ClassBuilder exceptions, ensuring every exception carries a BuildStack and a textual cause.
 *
 * @method BuildStack getBuildStack() Returns the BuildStack snapshot at the point of failure.
 * @method string     getCause()      Returns a human-readable description of the failure reason.
 *
 * @io -> BuildStack, string
 */
interface BuildExceptionInterface
{
    public function getBuildStack(): BuildStack;

    public function getCause(): string;
}
// endregion INTERFACE_BuildExceptionInterface
