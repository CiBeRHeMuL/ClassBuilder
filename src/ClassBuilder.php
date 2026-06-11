<?php

// GREP_SUMMARY: ClassBuilder, build, buildArray, reflection, object construction, type resolution, inheritors, BuildStack
// STRUCTURE: build ┌class+data┐ → checkClass → [inheritors?] → buildTypes → buildType → {buildObject|buildPrimitive|buildDateTime|buildBackedEnum|buildUnitEnum|buildArrayType} → ∑ return object

namespace AndrewGos\ClassBuilder;

use AndrewGos\ClassBuilder\Attribute\ArrayType;
use AndrewGos\ClassBuilder\Attribute\AvailableInheritors;
use AndrewGos\ClassBuilder\Attribute\BuildIf;
use AndrewGos\ClassBuilder\Attribute\CanBeBuiltFromScalar;
use AndrewGos\ClassBuilder\Attribute\Field;
use AndrewGos\ClassBuilder\BuildStack\BuildStack;
use AndrewGos\ClassBuilder\Checker\CheckerInterface;
use AndrewGos\ClassBuilder\Exception as Exp;
use BackedEnum;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Throwable;
use UnitEnum;

// region MODULE_CONTRACT [DOMAIN(10): ClassBuilder; CONCEPT(10): ReflectionBuilder; TECH(10): PHP8Attributes]
/**
 * @moduleContract
 * @purpose Центральный движок библиотеки: рекурсивно конструирует объекты, enum'ы, DateTime, массивы и примитивы на основе PHP reflection и пользовательских атрибутов.
 * @scope Полный цикл построения: валидация класса, разрешение inheritance, связывание параметров конструктора, построение вложенных типов.
 * @input Имя класса (class-string), произвольные данные (mixed), опциональный BuildStack и флаг throwOnError.
 * @output Сконструированный объект указанного типа, null при ошибке (если throwOnError=false) или массив объектов.
 *
 * @links USES_API(10): ReflectionClass, ReflectionParameter, ReflectionNamedType, ReflectionUnionType, ReflectionIntersectionType; USES_ATTRIBUTE(10): ArrayType, AvailableInheritors, BuildIf, CanBeBuiltFromScalar, Field
 *
 * @invariants
 * - Кэш reflection'а (reflections) никогда не инвалидируется в течение жизни экземпляра.
 * - Результаты checkClass кэшируются в checkedClasses для предотвращения повторной валидации.
 * - Матрица типов (types) кэшируется по строковому представлению ReflectionType.
 *
 * @rationale
 * Q: Почему кэш не инвалидируется?
 * A: В рамках одного запроса (build) class-структура не меняется; кэш ускоряет массовое построение однотипных объектов.
 *
 * @changes
 * LAST_CHANGE: v1.0.0 Initial semantic markup
 *
 * @modulemap
 * CLASS 10[Core engine] => ClassBuilder
 *
 * @usecases
 * - [ClassBuilder::build()]: Клиент → Указать класс и данные → Получить объект
 * - [ClassBuilder::buildArray()]: Клиент → Указать класс и массив данных → Получить массив объектов
 */
// endregion MODULE_CONTRACT
// region CLASS_ClassBuilder [DOMAIN(10): ClassBuilder; CONCEPT(10): ReflectionObjectBuilder; TECH(10): PHP8]
class ClassBuilder implements ClassBuilderInterface
{
    /**
     * @var array<class-string, array{bool, Exp\BuildExceptionInterface|null}>
     */
    private array $checkedClasses = [];
    /**
     * @var array<class-string, ReflectionClass>
     */
    private array $reflections = [];
    /**
     * @var array<class-string, class-string[]>
     */
    private array $inheritors = [];
    /**
     * @var array<class-string, bool>
     */
    private array $canBuildFromPrimitive = [];
    /**
     * @var array<class-string, CheckerInterface|null>
     */
    private array $buildIfs = [];
    /**
     * @var array<string, string[]>
     */
    private array $types = [];

    // region METHOD_build [DOMAIN(10): ClassBuilder; CONCEPT(10): EntryPoint; TECH(9): BuildStack]
    /**
     * @purpose Main entry point: construct a single object of the given class from arbitrary data.
     * @io string $class, mixed $data, bool $throwOnError, ?BuildStack $stack -> ?object
     * @complexity 4
     *
     * @param string          $class        Target class name (FQCN)
     * @param mixed           $data         Source data (array, scalar, etc.)
     * @param bool            $throwOnError If true, throw on failure; if false, return null
     * @param BuildStack|null $stack        Optional external stack for chaining builds
     *
     * @return object|null Constructed object or null on failure
     *
     * @throws Exp\BuildExceptionInterface On build failure when throwOnError=true
     */
    public function build(string $class, mixed $data, bool $throwOnError = true, ?BuildStack &$stack = null): ?object
    {
        try {
            $needPop = false;
            if ($stack === null) {
                $stack = new BuildStack();
                $stack->addObject($class, $class, get_debug_type($data));
                $needPop = true;
            }
            $result = $this->buildObject($class, $data, $stack);
            $needPop && $stack->pop();

            return $result;
        } catch (Throwable $e) {
            if ($throwOnError) {
                if ($e instanceof Exp\BuildExceptionInterface) {
                    throw $e;
                }
                throw new Exp\UnknownException($stack, $e);
            } else {
                return null;
            }
        }
    }
    // endregion METHOD_build

    // region METHOD_buildArray [DOMAIN(10): ClassBuilder; CONCEPT(10): ArrayBuilding; TECH(9): TypedArray]
    /**
     * @purpose Construct an array of objects of the given class from a data array.
     * @io string $class, array $data, bool $throwOnError, ?BuildStack $stack -> array
     * @complexity 5
     *
     * @param string          $class        Target class name (FQCN)
     * @param array           $data         Array of source data entries
     * @param bool            $throwOnError If true, throw on failure; if false, return empty array
     * @param BuildStack|null $stack        Optional external stack for chaining builds
     *
     * @return array Array of constructed objects
     *
     * @throws Exp\BuildExceptionInterface On build failure when throwOnError=true
     */
    public function buildArray(string $class, array $data, bool $throwOnError = true, ?BuildStack &$stack = null): array
    {
        try {
            $stack ??= new BuildStack();
            $stack->addTypedArray($class, $class, 'array');
            $result = [];
            foreach ($data as $key => $value) {
                $stack->addObject("$key", $class, get_debug_type($value));
                $result[$key] = $this->build($class, $value, stack: $stack);
                $stack->pop();
            }
            $stack->pop();

            return $result;
        } catch (Throwable $e) {
            if ($throwOnError) {
                if ($e instanceof Exp\BuildExceptionInterface) {
                    throw $e;
                }
                throw new Exp\UnknownException($stack, $e);
            } else {
                return [];
            }
        }
    }
    // endregion METHOD_buildArray

    // region METHOD_buildTypes [DOMAIN(10): ClassBuilder; CONCEPT(10): TypeResolution; TECH(9): UnionIntersection]
    /**
     * @purpose Try each type from a union/intersection list until one succeeds; rethrows last error on exhaustion.
     * @io (string|ArrayType)[], mixed, BuildStack -> mixed
     * @complexity 5
     *
     * @param (string|ArrayType)[] $types Ordered list of types to try
     * @param mixed                $data  Source data
     * @param BuildStack           $stack Build context stack
     *
     * @return mixed Successfully built value
     *
     * @throws Exp\CannotBuildException When all types fail
     */
    private function buildTypes(array $types, mixed $data, BuildStack &$stack): mixed
    {
        $dataType = get_debug_type($data);
        if (in_array($dataType, $types, true)) {
            return $data;
        }

        $types = array_values($types);
        foreach ($types as $k => $type) {
            try {
                return $this->buildType($type, $data, $stack);
            } catch (Exp\BuildExceptionInterface $e) {
                if ($k === count($types) - 1) {
                    throw $e;
                }
            } catch (Throwable $e) {
                if ($k === count($types) - 1) {
                    throw new Exp\UnknownException($stack, $e);
                }
            }
        }
        throw new Exp\CannotBuildException($stack);
    }
    // endregion METHOD_buildTypes

    // region METHOD_buildType [DOMAIN(10): ClassBuilder; CONCEPT(10): TypeRouting; TECH(9): ReflectionType]
    /**
     * @purpose Route type to the appropriate builder based on its category: class, enum, DateTime, primitive, or ArrayType.
     * @io string|ArrayType, mixed, BuildStack -> mixed
     * @complexity 6
     *
     * @param string|ArrayType $type  Type descriptor
     * @param mixed            $data  Source data
     * @param BuildStack       $stack Build context stack
     *
     * @return mixed Constructed value
     *
     * @throws Exp\CannotBuildException When type cannot be built
     */
    private function buildType(string|ArrayType $type, mixed $data, BuildStack &$stack): mixed
    {
        if ($type instanceof ArrayType) {
            return $this->buildArrayType($type, $data, $stack);
        } elseif (is_subclass_of($type, BackedEnum::class, true)) {
            return $this->buildBackedEnum($type, $data, $stack);
        } elseif (is_subclass_of($type, UnitEnum::class, true)) {
            return $this->buildUnitEnum($type, $data, $stack);
        } elseif (is_subclass_of($type, DateTimeInterface::class, true)) {
            return $this->buildDateTime($type, $data, $stack);
        } elseif (class_exists($type) || interface_exists($type)) {
            return $this->buildObject($type, $data, $stack);
        } elseif (
            in_array(
                $type,
                ['int', 'integer', 'float', 'double', 'string', 'bool', 'boolean', 'null', 'array'],
            )
        ) {
            return $this->buildPrimitive($type, $data, $stack);
        }
        throw new Exp\CannotBuildException($stack);
    }
    // endregion METHOD_buildType

    // region METHOD_buildPrimitive [DOMAIN(10): ClassBuilder; CONCEPT(10): PrimitiveCasting; TECH(9): TypeCasting]
    /**
     * @purpose Cast data to a primitive PHP type (int, float, string, bool, null, array).
     * @io string, mixed, BuildStack -> bool|int|float|string|array|null
     * @complexity 3
     *
     * @param string     $type  Target primitive type name
     * @param mixed      $data  Source data
     * @param BuildStack $stack Build context stack
     *
     * @return bool|int|float|string|array|null Cast value
     *
     * @throws Exp\CannotBuildException When cast is not possible
     */
    private function buildPrimitive(string $type, mixed $data, BuildStack &$stack): bool|int|float|string|array|null
    {
        if (is_scalar($data) || is_null($data) || is_array($data)) {
            return match (true) {
                in_array($type, ['int', 'integer']) && !is_array($data) => (int) $data,
                in_array($type, ['float', 'double']) && !is_array($data) => (float) $data,
                in_array($type, ['string']) && !is_array($data) => (string) $data,
                in_array($type, ['bool', 'boolean']) => (bool) $data,
                in_array($type, ['null']) && empty($data) => null,
                in_array($type, ['array']) => (array) $data,
                default => throw new Exp\CannotBuildException($stack),
            };
        }
        throw new Exp\CannotBuildException($stack);
    }
    // endregion METHOD_buildPrimitive

    // region METHOD_buildDateTime [DOMAIN(10): ClassBuilder; CONCEPT(10): DateTimeConstruction; TECH(9): DateTime]
    /**
     * @purpose Construct DateTime or DateTimeImmutable from string or serialized array.
     * @io string, mixed, BuildStack -> DateTimeInterface
     * @complexity 4
     *
     * @param string     $type  DateTime or DateTimeImmutable FQCN
     * @param mixed      $data  Date string or unserialize-compatible array
     * @param BuildStack $stack Build context stack
     *
     * @return DateTimeInterface Constructed DateTime/DateTimeImmutable
     *
     * @throws Exp\CannotBuildException   On invalid date data
     * @throws Exp\ClassNotFoundException When type is not DateTime/DateTimeImmutable
     */
    private function buildDateTime(string $type, mixed $data, BuildStack &$stack): DateTimeInterface
    {
        if ($type === DateTime::class) {
            try {
                return new DateTime($data);
            } catch (Throwable) {
                try {
                    $dt = new DateTime();
                    $dt->__unserialize($data);

                    return $dt;
                } catch (Throwable) {
                    throw new Exp\CannotBuildException($stack);
                }
            }
        } elseif ($type === DateTimeImmutable::class) {
            try {
                return new DateTimeImmutable($data);
            } catch (Throwable) {
                try {
                    $dt = new DateTimeImmutable();
                    $dt->__unserialize($data);

                    return $dt;
                } catch (Throwable) {
                    throw new Exp\CannotBuildException($stack);
                }
            }
        } else {
            throw new Exp\ClassNotFoundException($stack);
        }
    }
    // endregion METHOD_buildDateTime

    // region METHOD_buildBackedEnum [DOMAIN(10): ClassBuilder; CONCEPT(10): BackedEnumConstruction; TECH(9): BackedEnum]
    /**
     * @purpose Construct a BackedEnum instance from int or string value using enum::from().
     * @io string, mixed, BuildStack -> BackedEnum
     * @complexity 3
     *
     * @param string     $enum  BackedEnum FQCN
     * @param mixed      $data  Scalar value matching one of the enum cases
     * @param BuildStack $stack Build context stack
     *
     * @return BackedEnum Constructed enum instance
     *
     * @throws Exp\InvalidBackedEnumCaseException When value does not match any case
     * @throws Exp\CannotBuildEnumException       When data is not int|string
     * @throws Exp\EnumNotFoundException          When class is not a BackedEnum
     */
    private function buildBackedEnum(string $enum, mixed $data, BuildStack &$stack): BackedEnum
    {
        if (is_subclass_of($enum, BackedEnum::class, true)) {
            if (is_int($data) || is_string($data)) {
                try {
                    return $enum::from($data);
                } catch (Throwable) {
                    throw new Exp\InvalidBackedEnumCaseException($stack, $data);
                }
            } else {
                throw new Exp\CannotBuildEnumException($stack);
            }
        }
        throw new Exp\EnumNotFoundException($stack);
    }
    // endregion METHOD_buildBackedEnum

    // region METHOD_buildUnitEnum [DOMAIN(10): ClassBuilder; CONCEPT(10): UnitEnumConstruction; TECH(9): UnitEnum]
    /**
     * @purpose Construct a UnitEnum instance from string case name using $enum::$name syntax.
     * @io string, mixed, BuildStack -> UnitEnum
     * @complexity 3
     *
     * @param string     $enum  UnitEnum FQCN
     * @param mixed      $data  String case name
     * @param BuildStack $stack Build context stack
     *
     * @return UnitEnum Constructed enum instance
     *
     * @throws Exp\InvalidUnitEnumCaseException When case name is not found
     * @throws Exp\CannotBuildEnumException     When data is not a string
     * @throws Exp\EnumNotFoundException        When class is not a UnitEnum
     */
    private function buildUnitEnum(string $enum, mixed $data, BuildStack &$stack): UnitEnum
    {
        if (is_subclass_of($enum, UnitEnum::class, true)) {
            if (is_string($data)) {
                try {
                    return $enum::$$data;
                } catch (Throwable) {
                    throw new Exp\InvalidUnitEnumCaseException($stack, $data);
                }
            } else {
                throw new Exp\CannotBuildEnumException($stack);
            }
        }
        throw new Exp\EnumNotFoundException($stack);
    }
    // endregion METHOD_buildUnitEnum

    // region METHOD_buildArrayType [DOMAIN(10): ClassBuilder; CONCEPT(10): ArrayTypeBuilding; TECH(9): ArrayType]
    /**
     * @purpose Recursively build an array where elements conform to an ArrayType definition (supports nesting).
     * @io ArrayType, mixed, BuildStack -> array
     * @complexity 7
     *
     * @param ArrayType  $type  ArrayType descriptor with element type info
     * @param mixed      $data  Source array data
     * @param BuildStack $stack Build context stack
     *
     * @return array Built array with typed elements
     *
     * @throws Exp\CannotBuildException When data is not an array
     */
    private function buildArrayType(ArrayType $type, mixed $data, BuildStack &$stack): array
    {
        if (is_array($data)) {
            $subType = $type->getType();
            $result = [];
            foreach ($data as $key => $value) {
                if ($subType instanceof ArrayType) {
                    $stack->addTypedArray("$key", 'array', get_debug_type($data));
                    $result[$key] = $this->buildArrayType($subType, $value, $stack);
                } elseif (is_array($subType)) {
                    $stack->addUnion("$key", implode('|', $subType), get_debug_type($value));
                    $result[$key] = $this->buildTypes($subType, $value, $stack);
                } else {
                    if (class_exists($subType) || interface_exists($subType)) {
                        $stack->addObject("$key", $subType, get_debug_type($value));
                    } else {
                        $stack->addPrimitive("$key", $subType, get_debug_type($value));
                    }
                    $result[$key] = $this->buildType($subType, $value, $stack);
                }
                $stack->pop();
            }

            return $result;
        }
        throw new Exp\CannotBuildException($stack);
    }
    // endregion METHOD_buildArrayType

    // region METHOD_buildObject [DOMAIN(10): ClassBuilder; CONCEPT(10): ObjectConstruction; TECH(10): ReflectionParameter]
    /**
     * @purpose Core object builder: validates class, resolves inheritors, applies BuildIf checker, binds constructor parameters to data via Field/ArrayType attributes.
     * @io string, mixed, BuildStack -> object
     * @complexity 9
     *
     * @param string     $class Target class FQCN
     * @param mixed      $data  Source data (array or scalar if CanBeBuiltFromScalar)
     * @param BuildStack $stack Build context stack
     *
     * @return object Constructed object instance
     *
     * @throws Exp\CannotBuildException     On any build failure
     * @throws Exp\CannotBuildFromPrimitive When scalar build has wrong parameter count
     * @throws Exp\ValueNotFoundException   When required parameter is missing
     */
    private function buildObject(string $class, mixed $data, BuildStack &$stack): object
    {
        $this->checkClass($class, $stack);
        $reflection = $this->getReflection($class);
        $inheritors = $this->getInheritors($class);
        if ($inheritors) {
            return $this->buildTypes($inheritors, $data, $stack);
        }
        $checker = $this->getBuildIfChecker($class);
        $parameters = $reflection->getConstructor()?->getParameters() ?? [];
        $canBeBuiltFromPrimitive = $this->canBuildFromPrimitive($class);
        if ($canBeBuiltFromPrimitive) {
            $requiredParameters = array_filter(
                $parameters,
                fn(ReflectionParameter $p) => !$p->isOptional(),
            );
            if (!is_array($data) || array_is_list($data)) {
                if (count($requiredParameters) !== 1 && count($parameters) > 1) {
                    throw new Exp\CannotBuildFromPrimitive($stack);
                }
                $field = $parameters[0]->getName();
                $fieldAttr = $parameters[0]->getAttributes(Field::class);
                if ($fieldAttr) {
                    $field = $fieldAttr[0]->newInstance()->getField();
                }
                $data = [$field => $data];
            }
        }
        if ($checker === null || $checker->check($data) === true) {
            if (is_array($data)) {
                $boundParameters = [];
                $variadicParameter = null;
                foreach ($parameters as $parameter) {
                    $pName = $field = $parameter->getName();
                    $fieldAttr = $parameter->getAttributes(Field::class);
                    if ($fieldAttr) {
                        $field = $fieldAttr[0]->newInstance()->getField();
                    }
                    if (array_key_exists($field, $data)) {
                        $type = $parameter->getType();
                        if ($type) {
                            $types = $this->resolveTypes($type, $stack);
                            $arrayType = $parameter->getAttributes(ArrayType::class);
                            $arrayType = $arrayType ? $arrayType[0]->newInstance() : null;
                            if ($parameter->isVariadic()) {
                                $arrayType = $arrayType ? new ArrayType($arrayType) : new ArrayType($types);
                                if (!in_array('array', $types)) {
                                    $types[] = 'array';
                                }
                            }
                            if ($arrayType) {
                                foreach ($types as &$type) {
                                    if ($type === 'array') {
                                        $type = $arrayType;
                                    }
                                }
                            }

                            $stack->addUnion($pName, implode('|', $types), get_debug_type($data[$field]));
                            if ($parameter->isVariadic()) {
                                $variadicParameter = $this->buildTypes($types, $data[$field], $stack);
                            } else {
                                $boundParameters[$pName] = $this->buildTypes($types, $data[$field], $stack);
                            }
                            $stack->pop();
                        } else {
                            if ($parameter->isVariadic()) {
                                $variadicParameter = [$data];
                            } else {
                                $boundParameters[$pName] = $data[$field];
                            }
                        }
                    } else {
                        $isOptional = $parameter->isOptional();
                        $allowDefaultValue = $parameter->isDefaultValueAvailable();
                        $stack->addPrimitive($pName, (string) $parameter->getType() ?: 'mixed', 'null');
                        if ($isOptional && $allowDefaultValue) {
                            $boundParameters[$pName] = $parameter->getDefaultValue();
                        } else {
                            throw new Exp\ValueNotFoundException($stack);
                        }
                        $stack->pop();
                    }
                }
                if ($variadicParameter !== null) {
                    return new $class(...$boundParameters, ...$variadicParameter);
                }

                return new $class(...$boundParameters);
            }
            throw new Exp\CannotBuildException($stack);
        } else {
            throw new Exp\CannotBuildException($stack);
        }
    }
    // endregion METHOD_buildObject

    // region METHOD_checkClass [DOMAIN(10): ClassBuilder; CONCEPT(10): ClassValidation; TECH(9): ReflectionClass]
    /**
     * @purpose Validate class: check existence, abstract/interface has inheritors, inheritors are valid subclasses (no self-reference, no recursion).
     * @io string, BuildStack -> void (throws on failure)
     * @complexity 6
     *
     * @param string     $class Class FQCN to validate
     * @param BuildStack $stack Build context stack
     *
     * @return void
     *
     * @throws Exp\ClassNotFoundException       When class does not exist
     * @throws Exp\InheritorsNotSetException    When abstract/interface has no AvailableInheritors
     * @throws Exp\InvalidInheritorsException   When inheritor equals parent class
     * @throws Exp\InheritorsRecursionException When inheritor is not a subclass of parent
     */
    private function checkClass(string $class, BuildStack &$stack): void
    {
        if (isset($this->checkedClasses[$class])) {
            [$checked, $e] = $this->checkedClasses[$class];
            if ($checked === false) {
                throw $e;
            }

            return;
        }
        if (class_exists($class) || interface_exists($class)) {
            $reflection = $this->getReflection($class);
            if ($reflection) {
                $inheritors = $this->getInheritors($class);
                if (($reflection->isAbstract() || $reflection->isInterface()) && !$inheritors) {
                    throw new Exp\InheritorsNotSetException($stack);
                }
                $e = null;
                foreach ($inheritors as $inheritor) {
                    if ($inheritor === $class) {
                        $e = new Exp\InvalidInheritorsException($stack);
                        break;
                    } elseif (!is_subclass_of($inheritor, $class)) {
                        $e = new Exp\InheritorsRecursionException($stack);
                        break;
                    }
                }
                $this->checkedClasses[$class] = [$e === null, $e];
                if ($e) {
                    throw $e;
                }

                return;
            }
        }
        $e = new Exp\ClassNotFoundException($stack);
        $this->checkedClasses[$class] = [false, $e];
        throw $e;
    }
    // endregion METHOD_checkClass

    // region METHOD_getReflection [DOMAIN(10): ClassBuilder; CONCEPT(10): ReflectionCaching; TECH(9): ReflectionClass]
    /**
     * @purpose Get cached ReflectionClass instance for a class name; returns null on failure instead of throwing.
     * @io class-string -> ReflectionClass|null
     * @complexity 2
     *
     * @param class-string $class Target class FQCN
     *
     * @return ReflectionClass|null Cached reflection or null if class cannot be reflected
     */
    private function getReflection(string $class): ?ReflectionClass
    {
        if (isset($this->reflections[$class])) {
            return $this->reflections[$class];
        }
        try {
            $this->reflections[$class] = new ReflectionClass($class);

            return $this->reflections[$class];
        } catch (Throwable) {
            return null;
        }
    }
    // endregion METHOD_getReflection

    // region METHOD_getInheritors [DOMAIN(10): ClassBuilder; CONCEPT(10): InheritorResolution; TECH(9): AvailableInheritors]
    /**
     * @purpose Read AvailableInheritors attributes from class reflection, flatten and deduplicate the inheritor list.
     * @io class-string -> class-string[]
     * @complexity 4
     *
     * @param class-string $class Target class FQCN
     *
     * @return class-string[] Flat list of inheritor class names
     */
    private function getInheritors(string $class): array
    {
        if (isset($this->inheritors[$class])) {
            return $this->inheritors[$class];
        }
        $reflection = $this->getReflection($class);
        $inheritors = [];
        if ($reflection) {
            $inheritors = $reflection->getAttributes(AvailableInheritors::class);
            $inheritors = array_unique(array_filter(array_merge(...array_map(
                fn(ReflectionAttribute $a) => $a->newInstance()->getInheritors(),
                $inheritors,
            ))));
        }
        $this->inheritors[$class] = $inheritors;

        return $inheritors;
    }
    // endregion METHOD_getInheritors

    // region METHOD_canBuildFromPrimitive [DOMAIN(10): ClassBuilder; CONCEPT(10): ScalarBuildCheck; TECH(9): CanBeBuiltFromScalar]
    /**
     * @purpose Check if a class can be built from a scalar value (has CanBeBuiltFromScalar attribute or single required constructor parameter).
     * @io string -> bool
     * @complexity 3
     *
     * @param string $class Class FQCN
     *
     * @return bool True if class accepts scalar construction
     */
    private function canBuildFromPrimitive(string $class): bool
    {
        if (isset($this->canBuildFromPrimitive[$class])) {
            return $this->canBuildFromPrimitive[$class];
        }
        $reflection = $this->getReflection($class);
        if ($reflection) {
            $attr = $reflection->getAttributes(CanBeBuiltFromScalar::class);
            $this->canBuildFromPrimitive[$class] = (bool) $attr || $reflection->getConstructor()?->getNumberOfRequiredParameters() === 1;

            return $this->canBuildFromPrimitive[$class];
        }
        $this->canBuildFromPrimitive[$class] = false;

        return false;
    }
    // endregion METHOD_canBuildFromPrimitive

    // region METHOD_getBuildIfChecker [DOMAIN(10): ClassBuilder; CONCEPT(10): BuildIfChecker; TECH(9): BuildIfAttribute]
    /**
     * @purpose Read BuildIf attribute from class and instantiate the associated CheckerInterface.
     * @io string -> CheckerInterface|null
     * @complexity 3
     *
     * @param string $class Class FQCN
     *
     * @return CheckerInterface|null The configured checker, or null if no BuildIf attribute
     */
    private function getBuildIfChecker(string $class): ?CheckerInterface
    {
        if (array_key_exists($class, $this->buildIfs)) {
            return $this->buildIfs[$class];
        }
        $reflection = $this->getReflection($class);
        if ($reflection) {
            $attr = $reflection->getAttributes(BuildIf::class);
            if ($attr) {
                $this->buildIfs[$class] = $attr[0]->newInstance()->getChecker();

                return $this->buildIfs[$class];
            }
        }
        $this->buildIfs[$class] = null;

        return null;
    }
    // endregion METHOD_getBuildIfChecker

    // region METHOD_resolveTypes [DOMAIN(10): ClassBuilder; CONCEPT(10): TypeResolution; TECH(9): ReflectionType]
    /**
     * @purpose Flatten ReflectionType into a string array of type names; resolve intersection types through inheritor intersection.
     * @io ReflectionType, BuildStack -> string[]
     * @complexity 7
     *
     * @param ReflectionType $type  The reflection type to resolve
     * @param BuildStack     $stack Build context stack
     *
     * @return string[] Array of resolved type name strings
     *
     * @throws Exp\InheritorsNotSetException When intersection type references a class without AvailableInheritors
     */
    private function resolveTypes(ReflectionType $type, BuildStack &$stack): array
    {
        $typeStr = (string) $type;
        if (isset($this->types[$typeStr])) {
            return $this->types[$typeStr];
        }
        if ($type instanceof ReflectionNamedType) {
            $types = [$type->getName()];
            if ($type->allowsNull()) {
                $types[] = 'null';
            }
            $this->types[$typeStr] = $types;

            return $types;
        } elseif ($type instanceof ReflectionUnionType) {
            $types = $type->getTypes();
            $types = array_merge(...array_map(
                fn(ReflectionType $t) => $this->resolveTypes($t, $stack),
                $types,
            ));
            $this->types[$typeStr] = $types;

            return $types;
        } elseif ($type instanceof ReflectionIntersectionType) {
            $types = $type->getTypes();
            $preparedTypes = [];
            $init = false;
            foreach ($types as $t) {
                $pTypes = $this->resolveTypes($t, $stack);
                foreach ($pTypes as $pt) {
                    $inheritors = $this->getInheritors($pt);
                    if ($inheritors) {
                        if ($init === false) {
                            $preparedTypes = $inheritors;
                            $init = true;
                        } else {
                            $preparedTypes = array_intersect($preparedTypes, $inheritors);
                        }
                    } else {
                        throw new Exp\InheritorsNotSetException($stack);
                    }
                }
            }
            $types = array_values($preparedTypes);
            $this->types[$typeStr] = $types;

            return $types;
        }
        $this->types[$typeStr] = [];

        return [];
    }
    // endregion METHOD_resolveTypes
}
// endregion CLASS_ClassBuilder
