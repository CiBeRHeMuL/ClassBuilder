<?php

// GREP_SUMMARY: ClassBuilderInterface, build contract, buildArray contract, public API
// STRUCTURE: ┌build(class,data,throwOnError,stack) → ?object┐ ┌buildArray(class,data,throwOnError,stack) → array┐

namespace AndrewGos\ClassBuilder;

use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use AndrewGos\ClassBuilder\Exception\BuildExceptionInterface;

// region MODULE_CONTRACT [DOMAIN(10): ClassBuilder; CONCEPT(8): PublicContract; TECH(8): PHP8]
/**
 * @moduleContract
 * @purpose Public contract for object construction from arbitrary data. Defines build() and buildArray() entry points.
 * @scope Two methods: single object build and array-of-objects build.
 * @input Class name, data, throwOnError flag, optional BuildStack reference.
 * @output Constructed object, null, or array of objects.
 *
 * @links USES_API(10): BuildStack, BuildExceptionInterface
 *
 * @invariants
 * - build() returns null on failure only when throwOnError=false.
 * - buildArray() returns [] on failure only when throwOnError=false.
 *
 * @rationale
 * Q: Why does the interface use `= new BuildStack()` in the signature (invalid PHP)?
 * A: This is a known documentation issue; the implementation (ClassBuilder) uses `= null` internally. The interface signature is kept for historical compatibility but is not syntactically valid for direct use.
 *
 * @changes
 * LAST_CHANGE: v1.0.0 Initial semantic markup
 *
 * @modulemap
 * INTERFACE 10[Public API contract] => ClassBuilderInterface
 *
 * @usecases
 * - [build()]: Client → Call → Get constructed object
 * - [buildArray()]: Client → Call → Get array of objects
 */
// endregion MODULE_CONTRACT
interface ClassBuilderInterface
{
    // region METHOD_build [DOMAIN(10): ClassBuilder; CONCEPT(8): EntryPoint; TECH(8): BuildStack]
    /**
     * @purpose Build a single object from arbitrary data. Returns null on failure if throwOnError is false.
     * @io string, mixed, bool, ?BuildStack -> ?object
     * @complexity 1
     *
     * @param string          $class        Target class FQCN
     * @param mixed           $data         Source data
     * @param bool            $throwOnError If true, throw BuildExceptionInterface on failure; if false, return null
     * @param BuildStack|null $stack        Optional external BuildStack for tracking
     *
     * @return object|null Constructed object or null
     *
     * @throws BuildExceptionInterface When build fails and throwOnError is true
     */
    public function build(string $class, mixed $data, bool $throwOnError = true, ?BuildStack &$stack = new BuildStack()): ?object;
    // endregion METHOD_build

    // region METHOD_buildArray [DOMAIN(10): ClassBuilder; CONCEPT(8): EntryPoint; TECH(8): BuildStack]
    /**
     * @purpose Build an array of objects from array data. Returns [] on failure if throwOnError is false.
     * @io string, array, bool, ?BuildStack -> object[]
     * @complexity 1
     *
     * @param string          $class        Target class FQCN
     * @param array           $data         Array of source data items
     * @param bool            $throwOnError If true, throw BuildExceptionInterface on failure; if false, return []
     * @param BuildStack|null $stack        Optional external BuildStack for tracking
     *
     * @return object[] Array of constructed objects
     *
     * @throws BuildExceptionInterface When build fails and throwOnError is true
     */
    public function buildArray(string $class, array $data, bool $throwOnError = true, ?BuildStack &$stack = new BuildStack()): array;
    // endregion METHOD_buildArray
}
