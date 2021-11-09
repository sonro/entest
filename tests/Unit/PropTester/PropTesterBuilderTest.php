<?php

namespace Sonro\Entest\Tests\Unit\PropTester;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\PropTester\PropTester;
use Sonro\Entest\PropTester\PropTesterBuilder;
use Sonro\Entest\PropTester\PropTesterFactory;
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

    private function createPropTesterBuilder(): PropTesterBuilder {
        /** @var PropTesterFactory|Stub */
        $factory = $this->createStub(PropTesterFactory::class);
        $propTester = $this->createStub(PropTester::class);
        $factory->method("createPropTester")->willReturn($propTester);

        return new PropTesterBuilder("defaultPropName", $factory);
    }

    /**
     * @return Type
     */
    private function createDummyType()
    {
        return Type::mixed();
    }
}
