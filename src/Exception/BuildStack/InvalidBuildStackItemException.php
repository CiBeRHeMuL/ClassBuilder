<?php

namespace AndrewGos\ClassBuilder\Exception\BuildStack;

use AndrewGos\ClassBuilder\Enum\BuildStack\BuildStackItemSourceEnum;

class InvalidBuildStackItemException extends \RuntimeException
{
    public function __construct(
        BuildStackItemSourceEnum $pSource,
        BuildStackItemSourceEnum $source,
    ) {
        parent::__construct(
            sprintf(
                "Cannot add an item with type '%s' on top of an item with type '%s'",
                $source->getDescription(),
                $pSource->getDescription(),
            ),
            400,
        );
    }
}
