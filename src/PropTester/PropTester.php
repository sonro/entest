<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;

interface PropTester
{
    public function getPropInfo(): PropInfo;
}