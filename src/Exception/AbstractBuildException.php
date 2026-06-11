<?php

// GREP_SUMMARY: AbstractBuildException, base exception, BuildStack, RuntimeException

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use RuntimeException;

// region CLASS_AbstractBuildException [DOMAIN(8): Exception; CONCEPT(9): BaseClass; TECH(8): RuntimeException]
/**
 * @purpose Abstract base for all build exceptions: generates a detailed message from BuildStack ("Cannot build parameter 'path' of type 'X' from value of type 'Y' because Z").
 * Any concrete subclass must implement getCause(): string to provide the "Z" part.
 * @io BuildStack -> string (message)
 */
abstract class AbstractBuildException extends RuntimeException implements BuildExceptionInterface
{
    public function __construct(
        protected readonly BuildStack $buildStack,
    ) {
        $message = sprintf(
            <<<TEXT
                Cannot build %s of type '%s' from value of type '%s' because %s
                TEXT,
            $this->buildStack->getSize() > 1
                ? sprintf("parameter '%s'", (string) $this->buildStack)
                : 'value',
            $this->buildStack->getLast()->getTypePretty(),
            $this->buildStack->getLast()->getDataType(),
            $this->getCause(),
        );
        parent::__construct(
            $message,
        );
    }

    public function getBuildStack(): BuildStack
    {
        return $this->buildStack;
    }
}
// endregion CLASS_AbstractBuildException
