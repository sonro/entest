<?php

namespace Sonro\Entest\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\PropTester;
use Sonro\Entest\PropTesterBuilder;
use Sonro\Entest\Type;

class PropTesterBuilderTest extends TestCase
{
    public function test_exists(): void
    {
        $builder = $this->createPropTesterBuilder();
        $this->assertInstanceOf(PropTesterBuilder::class, $builder);
    }

    public function test_build_prop_tester(): void
    {
        $builder = $this->createPropTesterBuilder();
        $propTester = $builder->build();
        $this->assertInstanceOf(PropTester::class, $propTester);
    }

    public function test_chainable_methods(): void
    {
        $methods = [
            "type" => $this->createStub(Type::class),
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

    private function createPropTesterBuilder(): PropTesterBuilder {
        return new PropTesterBuilder("defaultPropName");
    }
}
