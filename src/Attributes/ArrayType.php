<?php

namespace AndrewGos\ClassBuilder\Attributes;

use Attribute;

/**
 * This attribute says to builder that array parameter have specified element type
 */
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
readonly class ArrayType
{
    /**
     * @param string|string[]|ArrayType $type
     */
    public function __construct(
        private string|array|ArrayType $type,
    ) {
    }

    /**
     * @return ArrayType|string[]|string
     */
    public function getType(): ArrayType|array|string
    {
        return $this->type;
    }
}
