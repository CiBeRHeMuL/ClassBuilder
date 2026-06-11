<?php

/*
 * @moduleContract
 * @purpose Interfaces and implementations for conditional object construction checks used by BuildIf attribute.
 * @scope Data validation against conditions before object construction proceeds.
 * @input Data array and comparison values.
 * @output Boolean result from check() method.
 * @links USES_API(8): CompareOperatorEnum
 * @links_to_spec ClassBuilder::buildObject() calls checker before constructing object
 * @invariants
 * - check() accepts any data type but typically receives an array.
 * - Checkers never modify the data, only inspect it.
 * @rationale
 * Q: Why separate checker classes instead of closures?
 * A: Checkers are serializable, testable, and composable (see AndChecker).
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * INTERFACE 8[Contract for data validation checks] => CheckerInterface
 * CLASS 7[Composite checker — logical AND over multiple checkers] => AndChecker
 * CLASS 8[Compares a data field with a value using a configurable operator] => FieldCompareChecker
 * CLASS 7[Checks equality of a data field with a reference value] => FieldIsChecker
 * @usecases
 * - [CheckerInterface]: Developer → Implement interface → Use in BuildIf attribute
 * - [AndChecker]: Developer → Combine multiple FieldIsCheckers → Conditional build on composite condition
 * - [FieldCompareChecker]: Developer → Check field > threshold → Conditional construction
 */
