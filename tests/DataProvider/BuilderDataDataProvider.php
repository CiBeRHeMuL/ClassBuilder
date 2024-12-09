<?php

namespace AndrewGos\ClassBuilder\Tests\DataProvider;

use AndrewGos\ClassBuilder\Tests\New\TestClass;
use AndrewGos\ClassBuilder\Tests\TestClasses as TC;

class BuilderDataDataProvider
{
    public static function generateSuccess(): array
    {
        return [
            [
                'class' => TC\SimpleClass::class,
                'data' => [
                    'a' => 1,
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.1234,
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
                'class' => TC\SimpleNotAllDefaultValueTest::class,
                'data' => [
                    'a' => 1,
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.1234,
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.1234, null],
                    'b' => [[1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null]],
                    'c' => ['asdf'],
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.1234, null],
                    'b' => [[1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null]],
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
                    'age' => 1234,
                ],
                'expected' => TC\SimpleInheritanceGoodChild3Class::class,
            ],
            [
                'class' => TC\SimpleInheritanceGoodClass::class,
                'data' => [
                    'name' => '3',
                    'age' => 1234,
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
                'class' => Tc\SimpleVariadic::class,
                'data' => ['a' => [1, 2, 3]],
            ],
            [
                'class' => Tc\SimpleVariadic::class,
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
        ];
    }

    public static function generateFailure(): array
    {
        return [
            [
                'class' => TC\SimpleClass::class,
                'data' => [
                    'a' => 1,
                    'b' => 'asdf',
                    'c' => false,
                    'd' => 1.1234,
                    'e' => null,
                ],
            ],
            [
                'class' => TC\SimpleDefaultValueClass::class,
                'data' => [
                    'a' => 'asdf',
                ],
            ],
            [
                'class' => TC\SimpleNotAllDefaultValueTest::class,
                'data' => [],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.1234, [], null],
                    'b' => [[1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, [], null]],
                    'c' => null,
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.1234, null],
                    'b' => [[1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, null], [1, 'asdf', false, 1.1234, [], null]],
                ],
            ],
            [
                'class' => TC\SimpleArrayClass::class,
                'data' => [
                    'a' => [1, 'asdf', false, 1.1234, null],
                    'b' => [1],
                ],
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => 1,
            ],
            [
                'class' => TC\SimpleScalarClass::class,
                'data' => ['a' => 1],
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
                    'age' => 'asdf',
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
        ];
    }

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
