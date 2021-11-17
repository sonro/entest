<?php declare(strict_types=1);

namespace Sonro\Entest\Tests\Unit\Prop;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\Prop\Prop;
use Sonro\Entest\Type;

class PropTest extends TestCase
{
    public function test_invalid_accessor_public_prop_with_getter(): void
    {
        $test = "public prop with getter";
        $info = ["public" => true, "getter" => true];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_accessor_public_prop_with_setter(): void
    {
        $test = "public prop with setter";
        $info = ["public" => true, "setter" => true];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_multi_prop_without_singular_name(): void
    {
        $test = "multi prop without singular name";
        $info = ["types" => $this->multiTypes()];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_non_multi_prop_with_adder(): void
    {
        $test = "non-multi prop with adder";
        $info = ["types" => $this->scalarTypes(), "adder" => true];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_non_multi_prop_with_remover(): void
    {
        $test = "non-multi prop with remover";
        $info = ["types" => $this->scalarTypes(), "remover" => true];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_non_multi_prop_with_singular_name(): void
    {
        $test = "non-multi prop with singular name";
        $info = ["types" => $this->scalarTypes(), "singularName" => "testName"];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_readonly_without_public(): void
    {
        $test = "readonly prop without public";
        $info = ["readonly" => true, "public" => false];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_non_nullable_prop_with_null_default(): void
    {
        $test = "non-nullable prop with null default";
        $info = [
            "nullable" => false,
            "usesDefaultValue" => true,
            "defaultValue" => null,
        ];
        $this->assertPropThrows($test, $info, \Exception::class);
    }

    public function test_invalid_prop_without_needed_original_test_value(): void
    {
        $test = "prop without needed original test value";
        $baseinfo = ["originalTestValue" => null];
        $originalInfos = [["getter" => true], ["public" => true]];
        $this->assertPropsThrow(
            $test,
            $baseinfo,
            $originalInfos,
            \Exception::class
        );
    }

    public function test_invalid_updatable_prop_without_update_test_value(): void
    {
        $test = "updatable prop without update test value";
        $baseinfo = ["nullable" => false, "updateTestValue" => null];
        $updateInfos = [
            ["setter" => true],
            ["adder" => true, "types" => $this->multiTypes()],
            ["public" => true],
        ];
        $this->assertPropsThrow(
            $test,
            $baseinfo,
            $updateInfos,
            \Exception::class
        );
    }

    private function assertPropsThrow(
        string $test,
        array $baseInfo,
        array $extraInfos,
        string $exceptionClass
    ): void {
        foreach ($extraInfos as $extraInfo) {
            $info = array_merge($baseInfo, $extraInfo);
            $this->assertPropThrows($test, $info, $exceptionClass);
        }
    }

    private function assertPropThrows(
        string $message,
        array $info,
        string $exceptionClass
    ): void {
        $this->expectExceptionMessage($message);
        $this->expectException($exceptionClass);
        $this->createProp($info);
    }

    private function createProp(array $info): Prop
    {
        return new Prop(
            name: $info["name"] ?? "testName",
            types: $info["types"] ?? [Type::int()],
            singularName: $info["singularName"] ?? "",
            nullable: $info["nullable"] ?? false,
            public: $info["public"] ?? false,
            readonly: $info["readonly"] ?? false,
            getter: $info["getter"] ?? false,
            setter: $info["setter"] ?? false,
            adder: $info["adder"] ?? false,
            remover: $info["remover"] ?? false,
            inConstructor: $info["inConstructor"] ?? false,
            usesDefaultValue: $info["usesDefaultValue"] ?? false,
            // use array_key_exists to check for null
            defaultValue: array_key_exists("defaultValue", $info)
                ? $info["defaultValue"]
                : 1,
            originalTestValue: array_key_exists("originalTestValue", $info)
                ? $info["originalTestValue"]
                : 2,
            updateTestValue: array_key_exists("updateTestValue", $info)
                ? $info["updateTestValue"]
                : 3
        );
    }

    private function scalarTypes(): array
    {
        return [Type::int()];
    }

    private function multiTypes(): array
    {
        return [Type::array(Type::int())];
    }
}
