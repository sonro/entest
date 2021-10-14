<?php declare(strict_types=1);

namespace Sonro\Entest;

class PropInfo
{
    public function __construct(
        private string $name,
        private Type $type,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): Type
    {
        return $this->type;
    }
}
