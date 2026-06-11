<?php

/*
 * @moduleContract
 * @purpose PHP 8 attributes for configuring ClassBuilder behaviour: type mapping, inheritance, conditional building, and scalar construction.
 * @scope Attribute definitions consumed by ClassBuilder via reflection.
 * @input Attribute instances attached to classes, parameters, and properties.
 * @output Configuration data read by ClassBuilder at runtime.
 * @links USES_API(10): PHP 8 Attributes
 * @links_to_spec ClassBuilder reads these attributes from ReflectionClass and ReflectionParameter
 * @invariants
 * - Each attribute targets the correct element (class, parameter, or property) as defined by its Attribute::TARGET_*.
 * - Attribute constructors accept only the types specified in their @param annotations.
 * @rationale
 * Q: Why attributes instead of YAML/JSON config?
 * A: Attributes keep configuration co-located with the code it configures, enabling type-safe and refactorable definitions.
 * @changes
 * LAST_CHANGE: v1.0.0 – Initial semantic markup of namespace contract
 * @modulemap
 * CLASS 8[Defines element type for typed arrays, supports nesting] => ArrayType
 * CLASS 7[Lists available inheritors for abstract classes/interfaces] => AvailableInheritors
 * CLASS 7[Attaches a CheckerInterface for conditional object construction] => BuildIf
 * CLASS 6[Marks class as buildable from scalar value] => CanBeBuiltFromScalar
 * CLASS 8[Overrides the data field name for a constructor parameter] => Field
 * @usecases
 * - [ArrayType]: Developer → Annotate array parameter with element type → ClassBuilder reads it for type-safe array building
 * - [AvailableInheritors]: Developer → List concrete inheritors on abstract class → ClassBuilder selects correct child
 * - [BuildIf]: Developer → Attach checker → ClassBuilder conditionally builds object
 * - [CanBeBuiltFromScalar]: Developer → Mark class → ClassBuilder builds from scalar instead of array
 * - [Field]: Developer → Map parameter to different data key → ClassBuilder uses custom field name
 */
