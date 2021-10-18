<?php

namespace Sonro\Entest\Tests\Unit;

use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Sonro\Entest\ComplexPropTester;
use Sonro\Entest\MixedPropTester;
use Sonro\Entest\PropInfo;
use Sonro\Entest\PropTesterFactory;
use Sonro\Entest\ScalarPropTester;
use Sonro\Entest\Type;

class PropTesterFactoryTest extends TestCase
{
    public function test_build_mixed_prop_tester(): void
    {
        $propInfo = $this->getDummyMixedPropInfo();
        $this->assertPropTesterType(MixedPropTester::class, $propInfo);
    }

    public function test_build_scalar_prop_tester(): void
    {
        $propInfo = $this->getDummyScalarPropInfo();
        $this->assertPropTesterType(ScalarPropTester::class, $propInfo);
    }

    public function test_build_complex_prop_tester(): void
    {
        $propInfo = $this->getDummyComplexPropInfo();
        $this->assertPropTesterType(ComplexPropTester::class, $propInfo);
    }

    private function assertPropTesterType(
        string $className,
        PropInfo $propInfo
    ): void {
        $factory = new PropTesterFactory();
        $propTester = $factory->createPropTester($propInfo);
        $this->assertInstanceOf($className, $propTester);
    }

    /**
     * @return PropInfo|Stub
     */
    private function getDummyMixedPropInfo()
    {
        $type = $this->getDummyMixedType();

        return $this->getDummyPropInfo($type);
    }

    /**
     * @return PropInfo|Stub
     */
    private function getDummyScalarPropInfo()
    {
        $type = $this->getDummyScalarType();

        return $this->getDummyPropInfo($type);
    }

    /**
     * @return PropInfo|Stub
     */
    private function getDummyComplexPropInfo()
    {
        $type = $this->getDummyComplexType();

        return $this->getDummyPropInfo($type);
    }

    /**
     * @return PropInfo|Stub
     */
    private function getDummyPropInfo(Type $type)
    {
        $stub = $this->createStub(PropInfo::class);
        $stub->method("getType")->willReturn($type);

        return $stub;
    }

    /**
     * @return Type|Stub
     */
    private function getDummyMixedType()
    {
        $stub = $this->createStub(Type::class);

        return $stub;
    }

    /**
     * @return Type|Stub
     */
    private function getDummyScalarType()
    {
        $stub = $this->createStub(Type::class);
        $stub->method("isScalar")->willReturn(true);

        return $stub;
    }

    /**
     * @return Type|Stub
     */
    private function getDummyComplexType()
    {
        $stub = $this->createStub(Type::class);
        $stub->method("isComplex")->willReturn(true);

        return $stub;
    }
}
