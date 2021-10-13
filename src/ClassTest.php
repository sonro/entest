<?php declare(strict_types=1);

namespace Sonro\Entest;

class ClassTest
{
    /**
     * @var PropTest[]
     */
    private array $propTests = [];

    /**
     * @param PropTest[] $propTests
     */
    public function __construct(
        private string $className,
        array $propTests,
    ) {
        $this->propTests = $propTests;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getPropTests(): array
    {
        return $this->propTests;
    }
}
