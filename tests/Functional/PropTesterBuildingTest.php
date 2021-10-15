<?php

namespace Sonro\Entest\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\PropInfo;
use Sonro\Entest\PropTesterBuilder;
use Sonro\Entest\Type;

class PropTesterBuildingTest extends TestCase
{
    public function test_prop_name_used_in_build(): void
    {
        $propName = "propertyName";
        $builder = new PropTesterBuilder($propName);
        $propInfo = $this->getBuiltPropInfo($builder);
        $actual = $propInfo->getName();
        $this->assertEquals($propName, $actual);
    }

    public function test_type_used_in_build(): void
    {
        $type = Type::string();

        $builder = $this->createPropTesterBuilder();
        $builder->type($type);
        $propInfo = $this->getBuiltPropInfo($builder);

        $actual = $propInfo->getType();
        $this->assertEquals($type, $actual);
    }

    private function getBuiltPropInfo($builder): PropInfo
    {
        $propTester = $builder->build();
        
        return $propTester->getPropInfo();
    }

    private function createPropTesterBuilder(): PropTesterBuilder
    {
        return new PropTesterBuilder("defaultPropName");
    }
}
