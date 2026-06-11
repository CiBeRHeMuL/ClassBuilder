<?php

// GREP_SUMMARY: BuilderDataDataProvider, test data, PHPUnit data provider, success cases, failure cases, intersection types
// STRUCTURE: generateSuccess() → array of ┌class + data + expected┐ → generateFailure() → array of ┌class + data┐ → generateNew() → array of ┌class + data + expected┐

namespace AndrewGos\ClassBuilder\Tests\DataProvider;

use AndrewGos\ClassBuilder\Tests\New\TestClass;
use AndrewGos\ClassBuilder\Tests\TestClasses as TC;

// region CLASS_BuilderDataDataProvider [DOMAIN(7): Testing; CONCEPT(7): DataProvider; TECH(7): PHPUnit]
/**
 * @purpose Provides test data sets for BuilderTest: success scenarios, expected failure scenarios, and new feature scenarios (intersection/union types, nested ArrayType).
 */
class BuilderDataDataProvider
{
    /**
     * @purpose Provide test cases that should succeed: primitive types, arrays, inheritance, DateTime, variadic, references, null values.
     * @io -> array
     * @complexity 2
     *
     * @return array Array of [class, data, expected?] test cases
     */
    public static function generateSuccess(): array
    {
        return [
            [
                'class' => TC\SimpleClass::class,
                'data' => [
                    'a' => 1,
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.123_4,
                    'e' => ['asdf', 1, false],
                    'f' => null,
                ],
            ],
            [
                'class' => TC\SimpleDefaultValueClass::class,
                'data' => [
                    'a' => 2,
                ],
            ],
            [
                'class' => TC\SimpleNotAllDefaultValue::class,
                'data' => [
                    'a' => 1,
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.123_4,
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.123_4, null],
                    'b' => [[1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null]],
                    'c' => ['asdf'],
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.123_4, null],
                    'b' => [[1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null]],
                    'c' => null,
                ],
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => 'asdf',
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => ['a' => 'asdf'],
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '1',
                ],
                'expected' => TC\SimpleInheritanceGoodChild1Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '2',
                ],
                'expected' => TC\SimpleInheritanceGoodChild2Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => '1',
                'expected' => TC\SimpleInheritanceGoodChild1Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => '2',
                'expected' => TC\SimpleInheritanceGoodChild2Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '3',
                    'age' => 1_234,
                ],
                'expected' => TC\SimpleInheritanceGoodChild3Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '3',
                    'age' => 1_234,
                ],
                'expected' => TC\SimpleInheritanceGoodChild3Class::class,
            ],
            [
                'class' => TC\ArrayClass::class,
                'data' => [
                    'a' => 'adsf',
                    'b' => ['asdf', 'asdf', ['a' => 'asdf']],
                ],
            ],
            [
                'class' => TC\AllClass::class,
                'data' => [
                    'a' => 3,
                    'b' => [
                        1,
                        0,
                        [
                            'a' => 3,
                            'b' => [1, ['a' => 3, 'b' => [], 'c' => []]],
                            'c' => ['asdf', ['a' => 'asdf']],
                        ],
                    ],
                    'c' => ['asdf', 'asdf'],
                ],
                'expected' => TC\All1Class::class,
            ],
            [
                'class' => TC\AllClass::class,
                'data' => 0,
                'expected' => TC\All2Class::class,
            ],
            [
                'class' => TC\SimpleVariadic::class,
                'data' => ['a' => [1, 2, 3]],
            ],
            [
                'class' => TC\SimpleVariadic::class,
                'data' => [1, 2, 3],
            ],
            [
                'class' => TC\DateTimeClass::class,
                'data' => '20240507',
            ],
            [
                'class' => TC\DateTimeClass::class,
                'data' => ['time' => '2024-05-07 01:01:01'],
            ],
            [
                'class' => TC\TestNull::class,
                'data' => ['a' => null],
            ],
            [
                'class' => TC\EmptyClass::class,
                'data' => [],
            ],
            [
                'class' => TC\ScalarWithoutAttribute::class,
                'data' => ['a' => 'asdf'],
            ],
            [
                'class' => TC\DateTimeClass::class,
                'data' => ['time' => ['date' => '1970-01-01 18:00:00.000000', 'timezone' => 'Europe/Moscow', 'timezone_type' => 3]],
            ],
            [
                'class' => TC\SimpleClass::class,
                'data' => [
                    'a' => 'asdf',
                    'b' => 'asdf',
                    'c' => 'asdf',
                    'd' => 'asdf',
                    'e' => 'asdf',
                    'f' => null,
                ],
            ],
            [
                'class' => TC\WithDefaultReferenceClass::class,
                'data' => [],
            ],
            [
                'class' => TC\WithoutDefaultReferenceClass::class,
                'data' => ['a' => 1],
            ],
            [
                'class' => TC\WithoutDefaultReferenceClass::class,
                'data' => ['a' => null],
            ],
        ];
    }

    /**
     * @purpose Provide test cases that should throw AbstractBuildException: type mismatches, missing required parameters, invalid inheritance.
     * @io -> array
     * @complexity 2
     *
     * @return array Array of [class, data] test cases
     */
    public static function generateFailure(): array
    {
        return [
            [
                'class' => TC\SimpleClass::class,
                'data' => [
                    'a' => [1],
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.123_4,
                    'e' => null,
                ],
            ],
            [
                'class' => TC\SimpleDefaultValueClass::class,
                'data' => [
                    'a' => ['asdf'],
                ],
            ],
            [
                'class' => TC\SimpleNotAllDefaultValue::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.123_4, [], null],
                    'b' => [[1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, [], null]],
                    'c' => [[null]],
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.123_4, null],
                    'b' => [[1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, null], [1, 'asdf', false, 1.123_4, [], null]],
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.123_4, null],
                    'b' => [1],
                ],
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => ['a' => []],
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleInheritanceBadClass::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleInheritanceBad1Class::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => ['name' => 'asdf'],
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '3',
                    'age' => ['asdf'],
                ],
            ],
            [
                'class' => TC\ArrayClass::class,
                'data' => [
                    'a' => 'adsf',
                    'b' => ['asdf', 'asdf', ['b' => 'asdf']],
                ],
            ],
            [
                'class' => TC\ArrayClass::class,
                'data' => [
                    'a' => 'adsf',
                    'b' => 'asdf',
                ],
            ],
            [
                'class' => TC\EmptyClass::class,
                'data' => 'asdf',
            ],
            [
                'class' => TC\ScalarWithoutAttribute::class,
                'data' => ['b' => 'asdf'],
            ],
            [
                'class' => TC\DateTimeClass::class,
                'data' => ['time' => ['date' => '1970-01-01 18:00:00.000000', 'timezone' => 'Europe/Moscow']],
            ],
        ];
    }

    /**
     * @purpose Provide test cases for new features: nullable types, union types, intersection types, nested ArrayType, variadic parameters with ArrayType.
     * @io -> array
     * @complexity 2
     *
     * @return array Array of [class, data, expected?] test cases
     */
    public static function generateNew(): array
    {
        return [
            [
                'class' => TestClass::class,
                'data' => [
                    'a' => null,
                    'b' => false,
                    'c' => 1,
                    'd' => 1.234,
                    'e' => 'asdf',
                    'f' => ['asdf'],
                    'g' => 'asdf',
                    'h' => [1, 2, 3, 4],
                    'i' => [[true], [false]],
                    'j' => ['a' => 2, 'b' => ['a' => 2, 'b' => 1]],
                    'k' => 1,
                    'l' => [
                        [['a' => 2, 'b' => ['a' => 2, 'b' => 1]], ['a' => 2, 'b' => ['a' => 2, 'b' => 1]]],
                        [['a' => 2, 'b' => ['a' => 2, 'b' => 1]], ['a' => 2, 'b' => ['a' => 2, 'b' => 1]]],
                    ],
                ],
            ],
        ];
    }
}
