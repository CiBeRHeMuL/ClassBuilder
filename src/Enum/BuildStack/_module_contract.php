<?php

/*
 * @moduleContract
 * @purpose Enumerations specific to BuildStack functionality: source types for stack items.
 * @scope Classification of BuildStackItem entries by their origin during object construction.
 * @input None (enums are static value definitions).
 * @output Enum cases used by BuildStack for validation and human-readable description.
 * @links USES_API(8): PHP 8 unit enums
 * @links_to_spec BuildStack::validatePrevElem() uses BuildStackItemSourceEnum to determine valid transitions
 * @invariants
 * - Each case corresponds to one type of build step (object, array, primitive, etc.).
 * - getDescription() provides a human-readable string for each case.
 * @rationale
 * Q: Why separate enum for source types?
 * A: Type-safe classification of stack items enables exhaustive matching in validatePrevElem() and __toString().
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * ENUM 8[Source types for BuildStackItem] => BuildStackItemSourceEnum
 * @usecases
 * - [BuildStackItemSourceEnum]: BuildStack → Classify stack items → Validate transitions and render path
 */
