<?php

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

    /**
     * @inheritDoc
     */
    public function build(string $class, mixed $data, bool $throwOnError = true, BuildStack|null &$stack = null): object|null
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
                } else {
                    throw new Exp\UnknownException($stack, $e);
                }
            } else {
                return null;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function buildArray(string $class, array $data, bool $throwOnError = true, BuildStack|null &$stack = null): array
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
                } else {
                    throw new Exp\UnknownException($stack, $e);
                }
            } else {
                return [];
            }
        }
    }

    /**
     * @param (string|ArrayType)[] $types
     * @param mixed $data
     * @param BuildStack $stack
     *
     * @return mixed
     */
    private function buildTypes(array $types, mixed $data, BuildStack &$stack): mixed
    {
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
        } else {
            throw new Exp\CannotBuildException($stack);
        }
    }

    private function buildPrimitive(string $type, mixed $data, BuildStack &$stack): null|bool|int|float|string|array
    {
        if (is_scalar($data) || is_null($data) || is_array($data)) {
            if (
                (in_array($type, ['int', 'integer']) && is_int($data))
                || (in_array($type, ['float', 'double']) && is_float($data))
                || ($type === 'string' && is_string($data))
                || (in_array($type, ['bool', 'boolean']) && is_bool($data))
                || ($type === 'null' && is_null($data))
                || ($type === 'array' && is_array($data))
            ) {
                return $data;
            }
        }
        throw new Exp\CannotBuildException($stack);
    }

    private function buildDateTime(string $type, mixed $data, BuildStack &$stack): DateTimeInterface
    {
        if ($type === DateTime::class) {
            try {
                return new DateTime($data);
            } catch (Throwable) {
                throw new Exp\CannotBuildException($stack);
            }
        } elseif ($type === DateTimeImmutable::class) {
            try {
                return new DateTimeImmutable($data);
            } catch (Throwable) {
                throw new Exp\CannotBuildException($stack);
            }
        } else {
            throw new Exp\ClassNotFoundException($stack);
        }
    }

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

    private function buildObject(string $class, mixed $data, BuildStack &$stack): object
    {
        $this->checkClass($class, $stack);
        $reflection = $this->getReflection($class);
        $inheritors = $this->getInheritors($class);
        if ($inheritors) {
            return $this->buildTypes($inheritors, $data, $stack);
        } else {
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
                    } else {
                        $field = $parameters[0]->getName();
                        $fieldAttr = $parameters[0]->getAttributes(Field::class);
                        if ($fieldAttr) {
                            $field = $fieldAttr[0]->newInstance()->getField();
                        }
                        $data = [$field => $data];
                    }
                }
            }
            if ($checker === null || $checker->check($data) === true) {
                if (is_array($data)) {
                    $boundParameters = [];
                    $variadicParameter = null;
                    foreach ($parameters as $parameter) {
                        if ($parameter->isPassedByReference()) {
                            $stack->addPrimitive(
                                $parameter->getName(),
                                (string)$parameter->getType(),
                                get_debug_type($data[$parameter->getName()] ?? null)
                            );
                            throw new Exp\CannotBuildReferenceException($stack);
                        }
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
                            $stack->addPrimitive($pName, (string)$parameter->getType() ?: 'mixed', 'null');
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
                    } else {
                        return new $class(...$boundParameters);
                    }
                } else {
                    throw new Exp\CannotBuildException($stack);
                }
            } else {
                throw new Exp\CannotBuildException($stack);
            }
        }
    }

    private function checkClass(string $class, BuildStack &$stack): void
    {
        if (isset($this->checkedClasses[$class])) {
            [$checked, $e] = $this->checkedClasses[$class];
            if ($checked === false) {
                throw $e;
            } else {
                return;
            }
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

    /**
     * @param class-string $class
     *
     * @return ReflectionClass|null
     */
    private function getReflection(string $class): ReflectionClass|null
    {
        if (isset($this->reflections[$class])) {
            return $this->reflections[$class];
        } else {
            try {
                $this->reflections[$class] = new ReflectionClass($class);
                return $this->reflections[$class];
            } catch (Throwable) {
                return null;
            }
        }
    }

    /**
     * @param class-string $class
     *
     * @return class-string[]
     */
    private function getInheritors(string $class): array
    {
        if (isset($this->inheritors[$class])) {
            return $this->inheritors[$class];
        } else {
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
    }

    private function canBuildFromPrimitive(string $class): bool
    {
        if (isset($this->canBuildFromPrimitive[$class])) {
            return $this->canBuildFromPrimitive[$class];
        } else {
            $reflection = $this->getReflection($class);
            if ($reflection) {
                $attr = $reflection->getAttributes(CanBeBuiltFromScalar::class);
                $this->canBuildFromPrimitive[$class] = !!$attr || $reflection->getConstructor()?->getNumberOfRequiredParameters() === 1;
                return $this->canBuildFromPrimitive[$class];
            }
            $this->canBuildFromPrimitive[$class] = false;
            return false;
        }
    }

    private function getBuildIfChecker(string $class): CheckerInterface|null
    {
        if (array_key_exists($class, $this->buildIfs)) {
            return $this->buildIfs[$class];
        } else {
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
    }

    /**
     * @param ReflectionType $type
     * @param BuildStack $stack
     *
     * @return string[]
     */
    private function resolveTypes(ReflectionType $type, BuildStack &$stack): array
    {
        $typeStr = (string)$type;
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
        } else {
            $this->types[$typeStr] = [];
            return [];
        }
    }
}
