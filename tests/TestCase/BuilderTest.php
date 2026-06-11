<?php

// GREP_SUMMARY: BuilderTest, PHPUnit, build success, build failure, null build, data provider
// STRUCTURE: testSuccessBuild ┌class+data┐ → build → assertInstanceOf → testSuccessNewBuild ┌class+data┐ → build → assertInstanceOf → testFailureBuild ┌class+data┐ → expectException → build → testNullBuild ┌data┐ → build → assertEquals

namespace AndrewGos\ClassBuilder\Tests\TestCase;

use AndrewGos\ClassBuilder\ClassBuilder;
use AndrewGos\ClassBuilder\Exception\AbstractBuildException;
use AndrewGos\ClassBuilder\Tests\DataProvider\BuilderDataDataProvider;
use AndrewGos\ClassBuilder\Tests\TestClasses\TestNull;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;

// region CLASS_BuilderTest [DOMAIN(7): Testing; CONCEPT(8): IntegrationTest; TECH(7): PHPUnit]
/**
 * @purpose Integration tests for ClassBuilder: verifies successful construction for all type categories, expected failures for invalid inputs, and new intersection/union type features.
 */
class BuilderTest extends TestCase
{
    /**
     * @purpose Verify that ClassBuilder::build() successfully constructs objects from valid data for all legacy test scenarios.
     * @io string, mixed, ?string -> void
     * @complexity 1
     *
     * @param string      $class    Target class FQCN
     * @param mixed       $data     Source data
     * @param string|null $expected Expected resulting class (for inheritance tests)
     *
     * @return void
     */
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateSuccess')]
    public function testSuccessBuild(string $class, mixed $data, ?string $expected = null): void
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }

    /**
     * @purpose Verify that ClassBuilder::build() successfully constructs objects from valid data for new feature test scenarios (intersection, union, nested ArrayType).
     * @io string, mixed, ?string -> void
     * @complexity 1
     *
     * @param string      $class    Target class FQCN
     * @param mixed       $data     Source data
     * @param string|null $expected Expected resulting class
     *
     * @return void
     */
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateNew')]
    public function testSuccessNewBuild(string $class, mixed $data, ?string $expected = null): void
    {
        $builder = new ClassBuilder();
        $expected ??= $class;
        $obj = $builder->build($class, $data);
        $this->assertInstanceOf($expected, $obj);
    }

    /**
     * @purpose Verify that ClassBuilder::build() throws AbstractBuildException for invalid input data.
     * @io string, mixed -> void
     * @complexity 1
     *
     * @param string $class Target class FQCN
     * @param mixed  $data  Invalid source data
     *
     * @return void
     */
    #[DataProviderExternal(BuilderDataDataProvider::class, 'generateFailure')]
    public function testFailureBuild(string $class, mixed $data): void
    {
        $builder = new ClassBuilder();
        $this->expectException(AbstractBuildException::class);
        $builder->build($class, $data);
    }

    /**
     * @purpose Verify that ClassBuilder::build() correctly handles nullable 'a' parameter with value 0 (not null).
     * @io -> void
     * @complexity 1
     *
     * @return void
     */
    public function testNullBuild(): void
    {
        $data = ['a' => 0];
        $builder = new ClassBuilder();
        $result = $builder->build(TestNull::class, $data);
        $this->assertEquals(new TestNull(0), $result);
    }
}
