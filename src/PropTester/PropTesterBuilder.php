<?php declare(strict_types=1);

namespace Sonro\Entest\PropTester;

use Sonro\Entest\Prop\PropInfo;
use Sonro\Entest\Type;

class PropTesterBuilder
{
    /**
     * @var Type[]
     */
    private array $types;

    private bool $union = false;

    public function __construct(
        private string $propName,
        private PropTesterFactory $factory,
    ) {
        $this->types = [Type::mixed()];
    }

    public function build(): PropTester
    {
        $propInfo = $this->generatePropInfo();
        
        return $this->factory->createPropTester($propInfo);
    }

    public function type(Type ...$types): self
    {
        $this->types = $types;
        if (count($types) > 1) {
            $this->union = true;
        }

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
            types: $this->types,
            union: $this->union,
        );
    }
}
