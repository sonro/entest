<?php

namespace Sonro\Entest\Tests;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\PropTester;
use Sonro\Entest\PropTesterBuilder;

class PropTesterBuilderTest extends TestCase
{
    public function test_exists()
    {
        $builder = $this->createPropTesterBuilder();
        $this->assertInstanceOf(PropTesterBuilder::class, $builder);
    }

    public function test_build_prop_tester()
    {
        $builder = $this->createPropTesterBuilder();
        $propTester = $builder->build();
        $this->assertInstanceOf(PropTester::class, $propTester);
    }

    public function test_prop_name_used_in_build()
    {
        $propName = "propertyName";
        $builder = $this->createPropTesterBuilder(propName: $propName);
        $propTester = $builder->build();
        $actual = $propTester->getPropInfo()->getName();
        $this->assertEquals($propName, $actual);
    }

    public function test_chainable_methods()
    {
        $methods = [
            "type" => null,
            "singularName" => null,
            "nullable" => null,
            "addGetter" => null,
            "addSetter" => null,
            "addAdder" => null,
            "addRemover" => null,
            "inConstructor" => null,
            "defaultValue" => null,
            "originalTestValue" => null,
            "updateTestValue" => null,
        ];
        $builder = $this->createPropTesterBuilder();
        foreach ($methods as $method => $value) {
            $result = $builder->$method($value);
            $this->assertEquals($builder, $result);
        }
    }

    private function createPropTesterBuilder(
        string $propName = null,
    ): PropTesterBuilder {
        return new PropTesterBuilder(
            propName: $propName ?? "defaultPropName",
        );
    }
}
