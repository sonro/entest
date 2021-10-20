<?php

namespace Sonro\Entest\Tests\Functional;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\ClassTester\ClassTesterBuilder;
use Sonro\Entest\PropTester\PropTester;

class ClassTesterBuildingTest extends TestCase
{
    public function test_class_name_used_in_build(): void
    {
        $classNames = ["ClassName", "AnotherClassName"];
        foreach ($classNames as $className) {
            $builder = new ClassTesterBuilder($className);
            $classTester = $builder->build();
            $actual = $classTester->getClassName();
            $this->assertEquals($className, $actual);
        }
    }

    public function test_add_prop_test_used_in_build(): void
    {
        $builder = $this->createClassTesterBuilder();
        $propTester = $this->getDummyPropTester();
        $builder->addPropTester($propTester);
        $classTester = $builder->build();
        $propTesters = $classTester->getPropTesters();
        $this->assertContains($propTester, $propTesters);
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
        return $this->createStub(PropTester::class);

    }
}
