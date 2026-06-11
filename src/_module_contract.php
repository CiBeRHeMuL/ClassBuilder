<?php

/*
 * @moduleContract
 * @purpose Core namespace of ClassBuilder library: builds objects from arbitrary data using PHP reflection.
 * @scope ClassBuilder engine, public contract interface.
 * @input Class name (string), mixed data, optional BuildStack and throwOnError flag.
 * @output Constructed object or array of objects; BuildExceptionInterface on failure.
 * @links USES_API(10): ReflectionClass, ReflectionParameter, ReflectionType, ReflectionNamedType, ReflectionUnionType, ReflectionIntersectionType
 * @links_to_spec Library entry points: build(), buildArray()
 * @invariants
 * - build() always returns an object of the requested type or null on failure (when throwOnError=false).
 * - buildArray() always returns an array of objects or empty array on failure.
 * - Cached reflection data is never invalidated within a single ClassBuilder instance.
 * @rationale
 * Q: Why one monolithic ClassBuilder instead of separate builders per type?
 * A: Single entry point simplifies client code and allows consistent error reporting via BuildStack.
 * Q: Why cache reflection results?
 * A: Building multiple objects of the same type is common; caching avoids repeated reflection overhead.
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * CLASS 10[Core engine that builds objects from data using reflection] => ClassBuilder
 * INTERFACE 8[Public contract for ClassBuilder] => ClassBuilderInterface
 * @usecases
 * - [ClassBuilder::build()]: Client → Provide class name + data → Receive constructed object
 * - [ClassBuilder::buildArray()]: Client → Provide class name + array data → Receive array of objects
 */
