<?php

namespace AndrewGos\ClassBuilder\Tests\TestCase;

use AndrewGos\ClassBuilder\ClassBuilder;
use AndrewGos\ClassBuilder\Exception\AbstractBuildException;
use AndrewGos\ClassBuilder\Tests\DataProvider\BuilderDataDataProvider;
use AndrewGos\ClassBuilder\Tests\TestClasses\TestNull;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateSuccess')]
    public function testSuccessBuild(string $class, mixed $data, string|null $expected = null): void
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }

    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateNew')]
    public function testSuccessNewBuild(string $class, mixed $data, string|null $expected = null): void
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }

    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateFailure')]
    public function testFailureBuild(string $class, mixed $data): void
    {
        $builder = new ClassBuilder();
        $this->expectException(AbstractBuildException::class);
        $builder->build($class, $data);
    }

    public function testNullBuild(): void
    {
        $data = ['a' => 0];
        $builder = new ClassBuilder();
        $result = $builder->build(TestNull::class, $data);
        $this->assertEquals(new TestNull(0), $result);
    }
}
