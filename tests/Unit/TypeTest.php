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
        $innerInt = Type::int();
        $innerFloat = Type::float();
        $data = [
            [Type::array($innerInt), Type::array($innerFloat)],
            [Type::collection($innerInt), Type::collection($innerFloat)],
            [Type::iterable($innerInt), Type::iterable($innerFloat)],
        ];

        foreach ($data as $pair) {
            $this->assertTrue($pair[0]->equals($pair[0]));
            $this->assertFalse($pair[0]->equals($pair[1]));
        }
    }

    public function test_get_inner_type(): void
    {
        $innerType = Type::string();
        $outerType = Type::collection($innerType);
        $this->assertEquals($innerType, $outerType->getInnerType());
    }

    public function test_is_scalar_is_true_for_scalar_values(): void
    {
        $scalarTypes = $this->getScalarTypes();
        foreach ($scalarTypes as $type) {
            $this->assertTrue($type->isScalar());
        }
    }

    public function test_is_scalar_is_false_for_non_scalar_values(): void
    {
        $scalarTypes = $this->getScalarTypes();
        $allTypes = $this->getTypes();
        $types = $this->arrayFilterOut($scalarTypes, $allTypes);

        foreach ($types as $type) {
            $this->assertFalse($type->isScalar());
        }
    }

    public function test_is_complex_is_true_for_complex_values(): void
    {
        $complexTypes = $this->getComplexTypes();
        foreach ($complexTypes as $type) {
            $this->assertTrue($type->isComplex());
        }
    }

    public function test_is_complex_is_false_for_non_complex_values(): void
    {
        $complexTypes = $this->getComplexTypes();
        $allTypes = $this->getTypes();
        $types = $this->arrayFilterOut($complexTypes, $allTypes);

        foreach ($types as $type) {
            $this->assertFalse($type->isComplex());
        }
    }

    public function test_to_string(): void
    {
        $types = $this->getTypesWithStringKeys();
        foreach ($types as $string => $type) {
            $this->assertEquals($string, $type->__toString());
        }
    }

    /**
     * @return Type[]
     */
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

    /**
     * @return Type[]
     */
    private function getScalarTypes(): array
    {
        return [Type::int(), Type::float(), Type::string(), Type::bool()];
    }

    /**
     * @return Type[]
     */
    private function getComplexTypes(): array
    {
        return [Type::object(), Type::custom("ClassName")];
    }

    private function arrayFilterOut(array $needles, array $haystack): array
    {
        return array_filter($haystack, fn ($x) => !in_array($x, $needles));
    }
}
