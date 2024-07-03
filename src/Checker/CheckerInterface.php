<?php

namespace AndrewGos\ClassBuilder\Checker;

interface CheckerInterface
{
    /**
     * Проверить данные на валидность
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function check(mixed $data): bool;
}
