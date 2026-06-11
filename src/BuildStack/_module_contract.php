<?php

/*
 * @moduleContract
 * @purpose BuildStack data structure for tracking the construction path through nested objects and generating human-readable error traces.
 * @scope Stack management during object building, validation of stack transitions.
 * @input BuildStackItem values pushed via add*() methods.
 * @output Build path string via __toString(), item retrieval via getLast()/getSize().
 * @links USES_API(9): BuildStackItem, BuildStackItemSourceEnum
 * @links_to_spec ClassBuilder uses BuildStack to report error context; AbstractBuildException renders BuildStack in exception message.
 * @invariants
 * - Stack transitions are validated: a Primitive item cannot have children; TypedArray/Variadic only accept Primitive/Object/TypedArray/Union.
 * - pop() never throws, ignores empty stack.
 * - __toString() always returns a non-empty path description for stacks with items.
 * @rationale
 * Q: Why a custom stack instead of a simple array?
 * A: Stack tracks the full traversal path, enabling detailed error messages (e.g., "parameter 'root->items[0]->name'").
 * Q: Why validate transitions at runtime?
 * A: Prevents logical bugs where wrong item types are nested, producing misleading error messages.
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * CLASS 10[Stack data structure for tracking build path] => BuildStack
 * CLASS 8[Immutable value object representing a single stack frame] => BuildStackItem
 * @usecases
 * - [BuildStack]: ClassBuilder → Push items during construction → Render path in exception messages
 */
