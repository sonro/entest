<?php declare(strict_types=1);

namespace Sonro\Entest;

class ClassTestBuilder
{
    /**
     * @var PropTest[]
     */
    private array $propTests = [];

    public function __construct(private string $className)
    {
    }

    public function build(): ClassTest
    {
        return new ClassTest($this->className, $this->propTests);
    }

    public function addPropTest(PropTest $propTest): self
    {
        $this->propTests[] = $propTest;

        return $this;
    }
}
