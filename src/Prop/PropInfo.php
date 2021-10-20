<?php declare(strict_types=1);

namespace Sonro\Entest\Prop;

use Sonro\Entest\Type;

class PropInfo
{
    private Type $type;

    /**
     * @param string $name
     * @param Type[] $types
     * @param bool $union
     */
    public function __construct(
        private string $name,
        private array $types,
        private bool $union,
    ) {
        $this->type = $this->types[0];
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Type[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function isUnion(): bool
    {
        return $this->union;
    }
}
