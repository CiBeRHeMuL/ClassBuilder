<?php

/*
 * @moduleContract
 * @purpose General-purpose enumerations used across the ClassBuilder library.
 * @scope Operator definitions for comparison logic.
 * @input None (enums are static value definitions).
 * @output Enum cases used by checker classes and other consumers.
 * @links USES_API(8): PHP 8 backed enums
 * @links_to_spec FieldCompareChecker uses CompareOperatorEnum to determine comparison behaviour
 * @invariants
 * - Each enum case is a single, immutable value.
 * @rationale
 * Q: Why backed enum for operators?
 * A: Backed string values allow serialization and clear string representation of the operator.
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * ENUM 7[Comparison operators for field value checks] => CompareOperatorEnum
 * @usecases
 * - [CompareOperatorEnum]: FieldCompareChecker → Select operator → Compare data field with expected value
 */
