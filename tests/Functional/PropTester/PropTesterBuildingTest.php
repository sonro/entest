<?php

namespace Sonro\Entest\Tests\Functional\PropTester;

use PHPUnit\Framework\TestCase;
use Sonro\Entest\Prop\PropInfo;
use Sonro\Entest\PropTester\PropTesterBuilder;
use Sonro\Entest\PropTester\PropTesterFactory;
use Sonro\Entest\Type;

class PropTesterBuildingTest extends TestCase
{
    public function test_prop_name_used_in_build(): void
    {
        $propName = "propertyName";
        $factory = $this->createFactory();
        $builder = new PropTesterBuilder($propName, $factory);

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
        $factory = $this->createFactory();

        return new PropTesterBuilder("defaultPropName", $factory);
    }

    private function createFactory(): PropTesterFactory
    {
        return new PropTesterFactory();
    }
}
