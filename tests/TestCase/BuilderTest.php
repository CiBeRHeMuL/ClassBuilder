<?php

namespace AndrewGos\ClassBuilder\Tests\TestCase;

use AndrewGos\ClassBuilder\ClassBuilder;
use AndrewGos\ClassBuilder\Exception\AbstractBuildException;
use AndrewGos\ClassBuilder\Tests\DataProvider\BuilderDataDataProvider;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateSuccess')]
    public function testSuccessBuild(string $class, mixed $data, string|null $expected = null)
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateNew')]
    public function testSuccessNewBuild(string $class, mixed $data, string|null $expected = null)
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }

    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateFailure')]
    public function testFailureBuild(string $class, mixed $data)
    {
        $builder = new ClassBuilder();
        $this->expectException(AbstractBuildException::class);
        $builder->build($class, $data);
    }
}
