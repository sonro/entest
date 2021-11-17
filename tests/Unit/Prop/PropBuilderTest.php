<?php declare(strict_types=1);

namespace Sonro\Entest\Tests\Unit\Prop;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\Prop\Prop;
use Sonro\Entest\Prop\PropBuilder;
use Sonro\Entest\Type;

class PropBuilderTest extends TestCase
{
    public function test_exists(): void
    {
        $builder = $this->createPropBuilder();
        $this->assertInstanceOf(PropBuilder::class, $builder);
    }

    public function test_build_prop(): void
    {
        $builder = $this->createPropBuilder();
        $prop= $builder->build();
        $this->assertInstanceOf(Prop::class, $prop);
    }

    public function test_chainable_methods(): void
    {
        $methods = $this->chainableMethods();
        $builder = $this->createPropBuilder();
        foreach ($methods as $method => $value) {
            $result = null === $value 
                ? $builder->$method() 
                : $builder->$method($value);
            $this->assertEquals($builder, $result);
        }
    }

    private function createPropBuilder(): PropBuilder
    {
        return new PropBuilder("defaultPropName");
    }

    /**
     * @return mixed[]|array<string, mixed>
     */
    private function chainableMethods(): array
    {
        return [
            "type" => $this->createDummyType(),
            "singularName" => "",
            "nullable" => null,
            "public" => null,
            "readonly" => null,
            "getter" => null,
            "setter" => null,
            "adder" => null,
            "remover" => null,
            "inConstructor" => null,
            "defaultValue" => 1,
            "originalTestValue" => 2,
            "updateTestValue" => 3,
        ];
    }

    /**
     * @return Type
     */
    private function createDummyType()
    {
        return Type::mixed();
    }
}
