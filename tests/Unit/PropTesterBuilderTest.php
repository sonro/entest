<?php

namespace Sonro\Entest\Tests\Unit;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\PropTester;
use Sonro\Entest\PropTesterBuilder;
use Sonro\Entest\MixedPropTester;
use Sonro\Entest\ScalarPropTester;
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
            "type" => $this->createDummyType(),
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

    public function test_build_default_mixed_prop_tester(): void
    {
        $builder = $this->createPropTesterBuilder();
        $propTester = $builder->build();
        $this->assertInstanceOf(MixedPropTester::class, $propTester);
    }

    public function test_build_configured_mixed_prop_tester(): void
    {
        $builder = $this->createPropTesterBuilder();
        $builder->type(Type::mixed());
        $propTester = $builder->build();
        $this->assertInstanceOf(MixedPropTester::class, $propTester);
    }

    public function test_build_scalar_prop_tester(): void
    {
        $builder = $this->createPropTesterBuilder();
        $builder->type(Type::int());
        $propTester = $builder->build();
        $this->assertInstanceOf(ScalarPropTester::class, $propTester);
    }

    private function createPropTesterBuilder(): PropTesterBuilder {
        return new PropTesterBuilder("defaultPropName");
    }

    /**
     * @return Type
     */
    private function createDummyType()
    {
        return Type::mixed();
    }
}
