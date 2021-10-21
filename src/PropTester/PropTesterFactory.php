<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;
use Sonro\Entest\Type;

class PropTesterFactory
{
    public function createPropTester(PropInfo $propInfo): PropTester
    {
        if ($propInfo->isUnion()) {
            return $this->createUnionPropTester($propInfo);
        }
        $type = $propInfo->getType();

        return $this->createSingularPropTester($propInfo, $type);
    }

    private function createUnionPropTester(PropInfo $propInfo): PropTester
    {
        $propTesters = [];
        foreach ($propInfo->getTypes() as $type) {
            $propTesters[] = $this->createSingularPropTester($propInfo, $type);
        }

        return new UnionPropTester($propInfo, $propTesters);
    }

    private function createSingularPropTester(PropInfo $propInfo, Type $type): PropTester
    {
        if ($type->isScalar()) {
            return new ScalarPropTester($propInfo);
        }
        if ($type->isComplex()) {
            return new ComplexPropTester($propInfo);
        }
        if ($type->isMulti()) {
            return new MultiPropTester($propInfo);
        }

        return new MixedPropTester($propInfo);
    }
}