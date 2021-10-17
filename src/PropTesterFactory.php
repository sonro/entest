<?php declare(strict_types=1);

namespace Sonro\Entest;

class PropTesterFactory
{
    public function createPropTester(PropInfo $propInfo): PropTester
    {
        $type = $propInfo->getType();

        if ($type->isScalar()) {
            return new ScalarPropTester($propInfo);
        }
        if ($type->isCustom()) {
            return new CustomPropTester($propInfo);
        }

        return new MixedPropTester($propInfo);
    }
}