<?php

// GREP_SUMMARY: CompareOperatorEnum, backed enum, comparison operators, string values
// STRUCTURE: cases: Equal(==), StrictEqual(===), NotEqual(!=), StrictNotEqual(!==), Greater(>), GreaterOrEqual(>=), Less(<), LessOrEqual(<=)

namespace AndrewGos\ClassBuilder\Enum;

// region CLASS_CompareOperatorEnum [DOMAIN(7): Enum; CONCEPT(7): Comparison; TECH(7): PHP8BackedEnum]
/**
 * @purpose Backed enumeration of comparison operators used by FieldCompareChecker for flexible data field validation.
 */
enum CompareOperatorEnum: string
{
    case Equal = '==';
    case StrictEqual = '===';
    case NotEqual = '!=';
    case StrictNotEqual = '!==';
    case Greater = '>';
    case GreaterOrEqual = '>=';
    case Less = '<';
    case LessOrEqual = '<=';
}
// endregion CLASS_CompareOperatorEnum
