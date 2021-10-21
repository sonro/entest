<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;

class UnionPropTester implements PropTester
{
    /**
     * @var PropTester[]
     */
    private array $propTesters;
    
    /**
     * @param PropInfo $propInfo
     * @param PropTester[] $propTesters
     */
    public function __construct(private PropInfo $propInfo, array $propTesters)
    {
        $this->propTesters = $propTesters;
    }

    public function getPropInfo(): PropInfo
    {
        return $this->propInfo;
    }
}
