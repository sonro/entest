<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;

class PropTesterFactory
{
    public function createPropTester(PropInfo $propInfo): PropTester
    {
        if ($propInfo->isUnion()) {
            // return union prop tester
        }

        $type = $propInfo->getType();
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