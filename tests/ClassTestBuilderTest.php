<?php

namespace Sonro\Entest\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\ClassTest;
use Sonro\Entest\ClassTestBuilder;
use Sonro\Entest\PropTest;

class ClassTestBuilderTest extends TestCase
{
    public function test_exists(): void
    {
        $builder = new ClassTestBuilder("ClassName");
        $this->assertInstanceOf(ClassTestBuilder::class, $builder);
    }

    public function test_build_class_test(): void
    {
        $builder = new ClassTestBuilder("ClassName");
        $classTest = $builder->build();
        $this->assertInstanceOf(ClassTest::class, $classTest);
    }

    public function test_class_name_used_in_build(): void
    {
        $className = "ClassName";
        $builder = new ClassTestBuilder($className);
        $classTest = $builder->build();
        $actual = $classTest->getClassName();
        $this->assertEquals($className, $actual);
    }

    public function test_add_prop_test_chainable(): void
    {
        $builder = new ClassTestBuilder("ClassName");
        $propTest = $this->getDummyPropTest();
        $result = $builder->addPropTest($propTest);
        $this->assertEquals($result, $builder);
    }

    public function test_add_prop_test_used_in_build(): void
    {
        $builder = new ClassTestBuilder("ClassName");
        $propTest = $this->getDummyPropTest();
        $builder->addPropTest($propTest);
        $classTest = $builder->build();
        $propTests = $classTest->getPropTests();
        $this->assertContains($propTest, $propTests);
    }

    /**
     * @return PropTest|MockObject
     */
    private function getDummyPropTest()
    {
        $propTest = $this->createMock(PropTest::class);

        return $propTest;
    }
}
