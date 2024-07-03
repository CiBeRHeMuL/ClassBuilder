<?php

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
readonly class AvailableInheritors
{
    /**
     * @param class-string[] $inheritors
     */
    public function __construct(
        private array $inheritors = [],
    ) {
    }

    /**
     * @return class-string[]
     */
    public function getInheritors(): array
    {
        return $this->inheritors;
    }
}
