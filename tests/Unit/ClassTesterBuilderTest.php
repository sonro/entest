<?php

namespace Sonro\Entest\Tests\Unit;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\ClassTester\ClassTester;
use Sonro\Entest\ClassTester\ClassTesterBuilder;
use Sonro\Entest\PropTester\PropTester;

class ClassTesterBuilderTest extends TestCase
{
    public function test_exists(): void
    {
        $builder = $this->createClassTesterBuilder();
        $this->assertInstanceOf(ClassTesterBuilder::class, $builder);
    }

    public function test_build_class_tester(): void
    {
        $builder = $this->createClassTesterBuilder();
        $classTester = $builder->build();
        $this->assertInstanceOf(ClassTester::class, $classTester);
    }

    public function test_add_prop_test_chainable(): void
    {
        $builder = $this->createClassTesterBuilder();
        $propTester = $this->getDummyPropTester();
        $result = $builder->addPropTester($propTester);
        $this->assertEquals($result, $builder);
    }

    private function createClassTesterBuilder(): ClassTesterBuilder
    {
        return new ClassTesterBuilder("DefaultClassName");
    }

    /**
     * @return PropTester|Stub
     */
    private function getDummyPropTester()
    {
        $propTester = $this->createStub(PropTester::class);

        return $propTester;
    }
}
