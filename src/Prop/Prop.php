<?php declare(strict_types=1);

namespace Sonro\Entest\Prop;

use Sonro\Entest\Type;

class Prop
{
    private bool $multi;
    private bool $union;

    /**
     * @param string $name
     * @param Type[] $types
     * @param string $singularName
     * @param boolean $nullable
     * @param boolean $public
     * @param boolean $readonly
     * @param boolean $getter
     * @param boolean $setter
     * @param boolean $adder
     * @param boolean $remover
     * @param boolean $inConstructor
     * @param boolean $usesDefaultValue
     * @param mixed $originalTestValue
     * @param mixed $defaultValue (optional)
     * @param mixed $updateTestValue (optional)
     */
    public function __construct(
        private string $name,
        private array $types,
        private string $singularName,
        private bool $nullable,
        private bool $public,
        private bool $readonly,
        private bool $getter,
        private bool $setter,
        private bool $adder,
        private bool $remover,
        private bool $inConstructor,
        private mixed $originalTestValue,
        private bool $usesDefaultValue,
        private mixed $defaultValue = null,
        private mixed $updateTestValue = null
    ) {
        $this->setMulti();
        $this->setUnion();

        $this->checkValidity();
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
        return $this->types[0];
    }

    public function getSingularName(): string
    {
        return $this->singularName;
    }

    public function isMulti(): bool
    {
        return $this->multi;
    }

    public function isUnion(): bool
    {
        return $this->union;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function hasGetter(): bool
    {
        return $this->getter;
    }

    public function hasSetter(): bool
    {
        return $this->setter;
    }

    public function hasAdder(): bool
    {
        return $this->adder;
    }

    public function hasRemover(): bool
    {
        return $this->remover;
    }

    public function isInConstructor(): bool
    {
        return $this->inConstructor;
    }

    public function hasDefaultValue(): bool
    {
        return $this->usesDefaultValue;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function getOriginalTestValue(): mixed
    {
        return $this->originalTestValue;
    }

    public function getUpdateTestValue(): mixed
    {
        return $this->updateTestValue;
    }

    public function isReadable(): bool
    {
        return $this->public || $this->getter;
    }

    public function isUpdatable(): bool
    {
        return $this->setter || $this->adder
            || ($this->public && $this->readonly === false);
    }

    private function setMulti(): void
    {
        foreach ($this->types as $type) {
            if ($type->isMulti()) {
                $this->multi = true;
                return;
            }
        }
        $this->multi = false;
    }

    private function setUnion(): void
    {
        $this->union = count($this->types) > 1;
    }

    private function checkValidity(): void
    {
        $this->checkAccessors();
        $this->checkMulti();
        $this->checkReadonly();
        $this->checkNull();
        $this->checkOriginal();
        $this->checkUpdate();
    }

    private function checkAccessors(): void
    {
        if ($this->public) {
            if ($this->getter) {
                throw new \Exception("public prop with getter");
            }

            if ($this->setter) {
                throw new \Exception("public prop with setter");
            }
        }
    }

    private function checkMulti(): void
    {
        $emptyName = empty($this->singularName);
        if ($this->multi) {
            if ($emptyName) {
                throw new \Exception("multi prop without singular name");
            }
        } else {
            if ($this->adder) {
                throw new \Exception("non-multi prop with adder");
            }
            if ($this->remover) {
                throw new \Exception("non-multi prop with remover");
            }
            if ($emptyName === false) {
                throw new \Exception("non-multi prop with singular name");
            }
        }
    }

    private function checkReadonly(): void
    {
        if (false === $this->public && $this->readonly) {
            throw new \Exception("readonly prop without public");
        }
    }

    private function checkNull(): void
    {
        if (false === $this->nullable) {
            if ($this->usesDefaultValue && $this->defaultValue === null) {
                throw new \Exception("non-nullable prop with null default");
            }
        }
    }

    private function checkOriginal(): void
    {
        $originalNeeded = $this->inConstructor || $this->isReadable();
        if ($originalNeeded && $this->originalTestValue === null) {
            throw new \Exception("prop without needed original test value");
        }
    }

    private function checkUpdate(): void
    {
        if ($this->isUpdatable() && $this->updateTestValue === null) {
            throw new \Exception("updatable prop without update test value");
        }
    }
}
