<?php

namespace AndrewGos\ClassBuilder\Checker;

readonly class AndChecker implements CheckerInterface
{
    /**
     * @param CheckerInterface[] $checkers
     */
    public function __construct(
        private array $checkers,
    ) {
    }

    public function check(mixed $data): bool
    {
        foreach ($this->checkers as $checker) {
            if (!$checker->check($data)) {
                return false;
            }
        }
        return true;
    }
}
