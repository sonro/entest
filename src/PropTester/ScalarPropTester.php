<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;

class ScalarPropTester implements PropTester
{
    public function __construct(private PropInfo $propInfo)
    {
    }

    public function getPropInfo(): PropInfo
    {
        return $this->propInfo;
    }
}
