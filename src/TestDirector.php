<?php declare(strict_types=1);

namespace Sonro\Entest;

use Sonro\Entest\PropTester\PropTester;
use Sonro\Entest\PropTester\PropTesterBuilder;
use Sonro\Entest\PropTester\PropTesterFactory;

class TestDirector
{
    private PropTesterFactory $propTesterFactory;

    /**
     * @var PropTesterBuilder[]
     */
    private array $propTesterBuilders = [];

    /**
     * @var PropTester[]
     */
    private array $propTesters = [];

    public function __construct()
    {
        $this->propTesterFactory = new PropTesterFactory();
    }

    public function createPropTesterBuilder(string $propName): PropTesterBuilder
    {
        $builder = new PropTesterBuilder($propName, $this->propTesterFactory);
        $this->propTesterBuilders[] = $builder;

        return $builder;
    }

    public function buildTesters(): void
    {
        foreach ($this->propTesterBuilders as $builder) {
            $this->propTesters[] = $builder->build();
        }
    }

    public function runTesters(): void
    {
    }
}
