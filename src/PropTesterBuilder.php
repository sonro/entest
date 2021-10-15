<?php declare(strict_types=1);

namespace Sonro\Entest;

class PropTesterBuilder
{
    private Type $type;

    private PropInfo $propInfo;

    public function __construct(private string $propName)
    {
        $this->type = Type::mixed();
        $this->propInfo = $this->generatePropInfo();
    }

    public function build(): PropTester
    {
        $this->propInfo = $this->generatePropInfo();

        if ($this->type->isScalar()) {
            return $this->buildScalar();
        }

        return $this->buildMixed();
    }

    private function buildScalar(): ScalarPropTester
    {
        return new ScalarPropTester($this->propInfo);
    }

    private function buildMixed(): MixedPropTester
    {
        return new MixedPropTester($this->propInfo);
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
        return new PropInfo(name: $this->propName, type: $this->type);
    }
}
