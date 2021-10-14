<?php declare(strict_types=1);

namespace Sonro\Entest;

class PropTesterBuilder
{
    private Type $type;

    public function __construct(private string $propName)
    {
        $this->type = Type::mixed();
    }

    public function build(): PropTester
    {
        $propInfo = $this->generatePropInfo();

        return new ScalarPropTester($propInfo);
    }

    public function type(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function singularName(): self
    {
        return $this;
    }

    public function nullable(): self
    {
        return $this;
    }

    public function addGetter(): self
    {
        return $this;
    }

    public function addSetter(): self
    {
        return $this;
    }

    public function addAdder(): self
    {
        return $this;
    }

    public function addRemover(): self
    {
        return $this;
    }

    public function inConstructor(): self
    {
        return $this;
    }

    public function defaultValue(): self
    {
        return $this;
    }

    public function originalTestValue(): self
    {
        return $this;
    }

    public function updateTestValue(): self
    {
        return $this;
    }

    private function generatePropInfo(): PropInfo
    {
        return new PropInfo(
            name: $this->propName,
            type: $this->type,
        );
    }
}
