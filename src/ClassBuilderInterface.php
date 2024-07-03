<?php

namespace AndrewGos\ClassBuilder;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use AndrewGos\ClassBuilder\Exception\BuildExceptionInterface;

interface ClassBuilderInterface
{
    /**
     * Build object from any data.
     * If an error occurred and `$throwOnError` is `true` then throw it,
     * else `null` will be returned
     *
     * @param string $class
     * @param mixed $data
     * @param bool $throwOnError
     * @param BuildStack $stack
     *
     * @return object|null
     * @throws BuildExceptionInterface
     */
    public function build(string $class, mixed $data, bool $throwOnError = true, BuildStack &$stack = new BuildStack()): object|null;

    /**
     * Build array of objects from array data.
     * If an error occurred and `$throwOnError` is `true` then throw it,
     * else `[]` will be returned
     *
     * @param string $class
     * @param array $data
     * @param bool $throwOnError
     * @param BuildStack $stack
     *
     * @return object[]
     * @throws BuildExceptionInterface
     */
    public function buildArray(string $class, array $data, bool $throwOnError = true, BuildStack &$stack = new BuildStack()): array;
}
