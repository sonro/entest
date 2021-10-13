<?php declare(strict_types=1);

namespace Sonro\Entest;

class ClassTester
{
    /**
     * @var PropTester[]
     */
    private array $propTesters = [];

    /**
     * @param PropTester[] $propTesters
     */
    public function __construct(
        private string $className,
        array $propTesters,
    ) {
        $this->propTesters = $propTesters;
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getPropTesters(): array
    {
        return $this->propTesters;
    }
}
