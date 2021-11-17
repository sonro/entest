<?php declare(strict_types=1);

namespace Sonro\Entest\Prop;

use Sonro\Entest\Type;

class PropBuilder
{
    private string $singularName = "";
    private bool $nullable = false;
    private bool $public = false;
    private bool $readonly = false;
    private bool $getter = false;
    private bool $setter = false;
    private bool $adder = false;
    private bool $remover = false;
    private bool $inConstructor = false;
    private bool $usesDefaultValue = false;
    private mixed $defaultValue = null;
    private mixed $originalTestValue = null;
    private mixed $updateTestValue = null;

    /** @var Type[] */
    private array $types = [];

    public function __construct(private string $name)
    {
    }

    public function build(): Prop
    {
        return $this->createProp();
    }

    public function type(Type ...$types): self
    {
        $this->types = $types;

        return $this;
    }

    public function singularName(string $singularName): self
    {
        $this->singularName = $singularName;

        return $this;
    }

    public function nullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    public function public(): self
    {
        $this->public = true;

        return $this;
    }

    public function readonly(): self
    {
        $this->readonly = true;
        $this->public = true;

        return $this;
    }

    public function getter(): self
    {
        $this->getter = true;

        return $this;
    }

    public function setter(): self
    {
        $this->setter = true;

        return $this;
    }

    public function adder(): self
    {
        $this->adder = true;

        return $this;
    }

    public function remover(): self
    {
        $this->remover = true;

        return $this;
    }

    public function inConstructor(): self
    {
        $this->inConstructor = true;

        return $this;
    }

    public function defaultValue(mixed $value): self
    {
        $this->defaultValue = $value;
        $this->usesDefaultValue = true;

        return $this;
    }

    public function originalTestValue(mixed $value): self
    {
        $this->originalTestValue = $value;

        return $this;
    }

    public function updateTestValue(mixed $value): self
    {
        $this->updateTestValue = $value;

        return $this;
    }

    private function createProp(): Prop
    {
        return new Prop(
            name: $this->name,
            types: $this->types,
            singularName: $this->singularName,
            nullable: $this->nullable,
            public: $this->public,
            readonly: $this->readonly,
            getter: $this->getter,
            setter: $this->setter,
            adder: $this->adder,
            remover: $this->remover,
            inConstructor: $this->inConstructor,
            usesDefaultValue: $this->usesDefaultValue,
            defaultValue: $this->defaultValue,
            originalTestValue: $this->originalTestValue,
            updateTestValue: $this->updateTestValue,
        );
    }
}
