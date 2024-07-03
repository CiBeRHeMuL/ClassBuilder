<?php

namespace AndrewGos\ClassBuilder\Exception;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use RuntimeException;

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
                ? sprintf("parameter '%s'", (string)$this->buildStack)
                : 'value',
            $this->buildStack->getLast()->getTypePretty(),
            $this->buildStack->getLast()->getDataType(),
            $this->getCause(),
        );
        parent::__construct(
            $message
        );
    }

    public function getBuildStack(): BuildStack
    {
        return $this->buildStack;
    }
}
