<?php

namespace Sonro\Entest\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\Type;

class TypeTest extends TestCase
{
    public function test_private_constructor(): void
    {
        $this->expectError();
        new Type(1);
    }

    public function test_equals_true(): void
    {
        $types = $this->getTypes();

        foreach ($types as $type) {
            $this->assertTrue($type->equals($type));
        }
    }

    public function test_equals_false(): void
    {
        $types = $this->getTypes();

        foreach ($types as $index => $type) {
            // get next value in array, index wraps around to start
            $indexRange = count($types) - 1;
            $i = ($index + 1) % $indexRange;

            $this->assertFalse($type->equals($types[$i]));
        }
    }

    public function test_equals_with_inner_type(): void
    {
        $arrayOfInts = Type::array(Type::int());
        $arrayOfFloats = Type::array(Type::float());
        
        $this->assertTrue($arrayOfInts->equals($arrayOfInts));
        $this->assertFalse($arrayOfInts->equals($arrayOfFloats));
    }

    public function test_get_inner_type(): void
    {
        $innerType = Type::string();
        $outerType = Type::collection($innerType);
        $this->assertEquals($innerType, $outerType->getInnerType());
    }

    public function test_to_string(): void
    {
        $types = $this->getTypesWithStringKeys();
        foreach ($types as $string => $type) {
            $this->assertEquals($string, $type->__toString());
        }
    }

    private function getTypes(): array
    {
        return array_values($this->getTypesWithStringKeys());
    }

    /**
     * @return array<string, Type>
     */
    private function getTypesWithStringKeys(): array
    {
        return [
            "int" => Type::int(),
            "float" => Type::float(),
            "string" => Type::string(),
            "bool" => Type::bool(),
            "object" => Type::object(),
            "ClassName" => Type::custom("ClassName"),
            "array<int>" => Type::array(Type::int()),
            "Collection<float>" => Type::collection(Type::float()),
            "iterable<bool>" => Type::iterable(Type::bool()),
            "resource" => Type::resource(),
            "null" => Type::null(),
            "callable" => Type::callable(),
            "mixed" => Type::mixed(),
        ];
    }
}
