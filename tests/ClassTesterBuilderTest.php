<?php

namespace Sonro\Entest\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\ClassTester;
use Sonro\Entest\ClassTesterBuilder;
use Sonro\Entest\PropTester;

class ClassTestererBuilderTest extends TestCase
{
    public function test_exists(): void
    {
        $builder = new ClassTesterBuilder("ClassName");
        $this->assertInstanceOf(ClassTesterBuilder::class, $builder);
    }

    public function test_build_class_tester(): void
    {
        $builder = new ClassTesterBuilder("ClassName");
        $classTester = $builder->build();
        $this->assertInstanceOf(ClassTester::class, $classTester);
    }

    public function test_class_name_used_in_build(): void
    {
        $className = "ClassName";
        $builder = new ClassTesterBuilder($className);
        $classTester = $builder->build();
        $actual = $classTester->getClassName();
        $this->assertEquals($className, $actual);
    }

    public function test_add_prop_test_chainable(): void
    {
        $builder = new ClassTesterBuilder("ClassName");
        $propTester = $this->getDummyPropTester();
        $result = $builder->addPropTester($propTester);
        $this->assertEquals($result, $builder);
    }

    public function test_add_prop_test_used_in_build(): void
    {
        $builder = new ClassTesterBuilder("ClassName");
        $propTester = $this->getDummyPropTester();
        $builder->addPropTester($propTester);
        $classTester = $builder->build();
        $propTesters = $classTester->getPropTesters();
        $this->assertContains($propTester, $propTesters);
    }

    /**
     * @return PropTester|MockObject
     */
    private function getDummyPropTester()
    {
        $propTester = $this->createMock(PropTester::class);

        return $propTester;
    }
}
