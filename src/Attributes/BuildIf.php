<?php

namespace AndrewGos\ClassBuilder\Attributes;

use AndrewGos\ClassBuilder\Checker\CheckerInterface;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class BuildIf
{
    public function __construct(
        private CheckerInterface $checker,
    ) {
    }

    public function getChecker(): CheckerInterface
    {
        return $this->checker;
    }
}
