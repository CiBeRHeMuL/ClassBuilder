<?php

/*
 * @moduleContract
 * @purpose Exceptions specific to BuildStack operations: invalid stack transitions.
 * @scope Validation errors within BuildStack data structure.
 * @input Two BuildStackItemSourceEnum values: parent source and attempted child source.
 * @output RuntimeException with HTTP 400 code describing the invalid transition.
 * @links USES_API(8): BuildStackItemSourceEnum, RuntimeException
 * @links_to_spec BuildStack::validatePrevElem() throws InvalidBuildStackItemException on invalid transitions
 * @invariants
 * - Exception is thrown before the invalid item is added to the stack.
 * - Exception message includes both source types for debugging.
 * @rationale
 * Q: Why a separate exception class for build stack errors?
 * A: Distinguishes structural errors (invalid nesting) from domain errors (missing values, unknown types).
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * CLASS 7[Thrown when a BuildStackItem is added on top of an incompatible parent] => InvalidBuildStackItemException
 * @usecases
 * - [InvalidBuildStackItemException]: BuildStack::validatePrevElem() → Invalid transition detected → Prevent stack corruption
 */
