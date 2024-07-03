# Class Builder Library

**Version 1.0**

## Description

This library provides functionality to build objects from arrays or scalars.

The library allows the construction of interfaces, abstract classes, arrays of objects. It also supports the construction of object parameters whose type is an array with typed elements. There is the possibility to build variadic parameters from arrays. Additionally, you can build classes with a single required parameter from scalar values. Parameters can also be assembled where the type is an intersection or union of types.

The library gathers information about object parameters from the constructor's parameters.

## Contacts

If you encounter a bug or have an idea, please write to [Gostev71@outlook.com](Gostev71@outlook.com) and type `Telegram Library Bug` or `Telegram Library Idea` in the email header.

## Installation

To install the library, use Composer:

```sh
composer require andrew-gos/class-builder
```

## Simple example

To build an object, write:
```php
<?php

use AndrewGos\ClassBuilder\ClassBuilder;

class A
{
    public function __construct(
        private int $a,
    ) {
    }
}

$classBuilder = new ClassBuilder();
$a = $classBuilder->build(A::class, ['a' => 1]);
```

## Building abstract classes and interfaces

To build an interface or an abstract class, specify the available inheritors using the `AvailableInheritors` attribute. \
The first successfully built object will be returned. \
This attribute can take array of inheritors. \

Note, that if you make class parameter type as intersection of types, then this library will build inheritors,
which contained in every interface or class in type
```php
<?php

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;

#[AvailableInheritors([B::class, C::class])]
interface A {}

class B implements A {}

class C implements A {}
```

## Data checkers for building

To control the building of interfaces or abstract classes, you can use the `BuildIf` attribute for the inheriting classes. \
This attribute instructs the builder to check the data before building. If the check fails, the builder will not construct the object. \
`BuildIf` attribute can take object of `CheckerInterface` attribute.
```php
<?php

use AndrewGos\ClassBuilder\Attributes\AvailableInheritors;
use AndrewGos\ClassBuilder\Attributes\BuildIf;
use AndrewGos\ClassBuilder\Checker\FieldIsChecker;

#[AvailableInheritors([B::class, C::class])]
interface A {}

#[BuildIf(new FieldIsChecker('type', 'b'))]
class B implements A {}

#[BuildIf(new FieldIsChecker('type', 'a'))]
class C implements A {}
```
In this example, an object of class `B` will be built only if the data contains a field `type` equal to `b`.

## Building typed arrays

To build typed arrays, use the `ArrayType` attribute. The attribute can take one type, an array of types, or an `ArrayType` object as a parameter.
```php
<?php

use AndrewGos\ClassBuilder\Attributes\ArrayType;

class A
{
    public function __construct(
        #[ArrayType('int')] private array $a,
    ) {
    }
}
```

## Building objects from scalars

If an object has only one required parameter, the library allows building such objects from scalar values. Use the `CanBeBuiltFromScalar` attribute.
```php
<?php

use AndrewGos\ClassBuilder\Attributes\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\ClassBuilder;

#[CanBeBuiltFromScalar]
class A
{
    public function __construct(
        private int $a,
    ) {
    }
}

$classBuilder = new ClassBuilder();
$a = $classBuilder->build(A::class, 1);
```
