<?php

// GREP_SUMMARY: CanBeBuiltFromScalar, attribute, scalar construction, marker
// STRUCTURE: ┌empty marker attribute┐ → ClassBuilder reads presence → allows scalar→object construction

namespace AndrewGos\ClassBuilder\Attribute;

use Attribute;

// region CLASS_CanBeBuiltFromScalar [DOMAIN(8): Attributes; CONCEPT(7): ScalarMarker; TECH(7): PHP8Attribute]
/**
 * @purpose Marker attribute indicating that a class can be constructed from a scalar value (string, int, etc.) instead of requiring an array.
 */
#[Attribute(Attribute::TARGET_CLASS)]
class CanBeBuiltFromScalar {}
// endregion CLASS_CanBeBuiltFromScalar
