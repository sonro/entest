<?php declare(strict_types=1);

namespace Sonro\Entest\ClassTester;

use Sonro\Entest\PropTester\PropTester;

class ClassTesterBuilder
{
    /**
     * @var PropTester[]
     */
    private array $propTesters = [];

    public function __construct(private string $className)
    {
    }

    public function build(): ClassTester
    {
        return new ClassTester($this->className, $this->propTesters);
    }

    public function addPropTester(PropTester $propTester): self
    {
        $this->propTesters[] = $propTester;

        return $this;
    }
}
