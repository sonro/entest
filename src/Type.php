<?php declare(strict_types=1);

namespace Sonro\Entest;

class Type
{
    private const INT = 1;
    private const FLOAT = 2;
    private const STRING = 3;
    private const BOOL = 4;
    private const OBJECT = 5;
    private const CUSTOM = 6;
    private const ARRAY = 7;
    private const COLLECTION = 8;
    private const ITERABLE = 9;
    private const RESOURCE = 10;
    private const NULL = 11;
    private const CALLABLE = 12;
    private const MIXED = 13;

    private string $className = "";
    private ?Type $innerType = null;

    private function __construct(private int $type)
    {
    }

    public static function int(): self
    {
        return new self(Self::INT);
    }

    public static function float(): self
    {
        return new self(Self::FLOAT);
    }

    public static function string(): self
    {
        return new self(Self::STRING);
    }

    public static function bool(): self
    {
        return new self(Self::BOOL);
    }

    public static function object(): self
    {
        return new self(Self::OBJECT);
    }

    public static function custom(string $className): self
    {
        $type = new self(Self::CUSTOM);
        $type->setClassName($className);

        return $type;
    }

    public static function array(Type $innerType): self
    {
        $type = new self(Self::ARRAY);
        $type->setInnerType($innerType);
        $innerString = $innerType->__toString();
        $type->setClassName("array<$innerString>");

        return $type;
    }

    public static function collection(Type $innerType): self
    {
        $type = new self(Self::COLLECTION);
        $type->setInnerType($innerType);
        $innerString = $innerType->__toString();
        $type->setClassName("Collection<$innerString>");

        return $type;
    }

    public static function iterable(Type $innerType): self
    {
        $type = new self(Self::ITERABLE);
        $type->setInnerType($innerType);
        $innerString = $innerType->__toString();
        $type->setClassName("iterable<$innerString>");

        return $type;
    }

    public static function resource(): self
    {
        return new self(Self::RESOURCE);
    }

    public static function null(): self
    {
        return new self(Self::NULL);
    }

    public static function callable(): self
    {
        return new self(Self::CALLABLE);
    }

    public static function mixed(): self
    {
        return new self(Self::MIXED);
    }

    public function equals(Type $anotherType): bool
    {
        return $this == $anotherType;
    }

    public function getInnerType(): ?Type
    {
        return $this->innerType;
    }

    public function isScalar(): bool
    {
        return match ($this->type) {
            Self::INT,
            Self::FLOAT,
            Self::STRING,
            Self::BOOL => true,
            default => false,
        };
    }

    public function isComplex(): bool
    {
        return match ($this->type) {
            Self::OBJECT,
            Self::CUSTOM => true,
            default => false,
        };
    }

    public function __toString(): string
    {
        return match ($this->type) {
            Self::INT => "int",
            Self::FLOAT => "float",
            Self::STRING => "string",
            Self::BOOL => "bool",
            Self::OBJECT => "object",
            Self::CUSTOM => $this->className,
            Self::ARRAY => $this->className,
            Self::COLLECTION => $this->className,
            Self::ITERABLE => $this->className,
            Self::RESOURCE => "resource",
            Self::NULL => "null",
            Self::CALLABLE => "callable",
            Self::MIXED => "mixed"
        };
    }

    private function setClassName(string $className): self
    {
        $this->className = $className;

        return $this;
    }

    private function setInnerType(Type $innerType): self
    {
        $this->innerType = $innerType;

        return $this;
    }
}
