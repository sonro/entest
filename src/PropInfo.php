<?php declare(strict_types=1);

namespace Sonro\Entest;

class PropInfo
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
