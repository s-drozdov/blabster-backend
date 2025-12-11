<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Adapter;

use Override;
use LogicException;
use Ramsey\Uuid\Uuid;
use DateTimeInterface;
use Ramsey\Uuid\Type\Hexadecimal;
use Ramsey\Uuid\Fields\FieldsInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Ramsey\Uuid\Type\Integer as IntegerObject;
use Ramsey\Uuid\Converter\NumberConverterInterface;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

final class RamseyAdapter implements UuidInterface
{
    private const string METHOD_MUST_NOT_BE_USED = 'Method must not be used';

    public function __construct(
        private RamseyUuidInterface $adaptee,
    ) {
        /*_*/
    }

    #[Override]
    public function compareTo(RamseyUuidInterface $other): int
    {
        return $this->adaptee->compareTo($other);
    }

    #[Override]
    public function equals(?object $other): bool
    {
        return $this->adaptee->equals($other);
    }

    /**
     * @psalm-external-mutation-free
     */
    #[Override]
    public function getBytes(): string
    {
        return $this->adaptee->getBytes();
    }

    #[Override]
    public function getFields(): FieldsInterface
    {
        return $this->adaptee->getFields();
    }

    #[Override]
    public function getHex(): Hexadecimal
    {
        return $this->adaptee->getHex();
    }

    #[Override]
    public function getInteger(): IntegerObject
    {
        return $this->adaptee->getInteger();
    }

    #[Override]
    public function getUrn(): string
    {
        return $this->adaptee->getUrn();
    }

    /**
     * @psalm-external-mutation-free
     */
    #[Override]
    public function toString(): string
    {
        return $this->adaptee->toString();
    }

    /**
     * @psalm-external-mutation-free
     */
    #[Override]
    public function __toString(): string
    {
        return $this->adaptee->__toString();
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getNumberConverter(): NumberConverterInterface
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getFieldsHex(): array
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getClockSeqHiAndReservedHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getClockSeqLowHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getClockSequenceHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getDateTime(): DateTimeInterface
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getLeastSignificantBitsHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getMostSignificantBitsHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getNodeHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getTimeHiAndVersionHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getTimeLowHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getTimeMidHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getTimestampHex(): string
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getVariant(): ?int
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    /**
     * @deprecated
     */
    #[Override]
    public function getVersion(): ?int
    {
        throw new LogicException(self::METHOD_MUST_NOT_BE_USED);
    }
    
    #[Override]
    public function jsonSerialize(): mixed
    {
        return $this->toString();
    }
    
    #[Override]
    public function serialize(): string
    {
        return $this->adaptee->toString();
    }

    #[Override]
    public function unserialize(string $data): void
    {
        $this->adaptee = Uuid::fromString($data);
    }

    public function __serialize(): array
    {
        return ['uuid' => $this->adaptee->toString()];
    }

    /**
     * @param array<string, string> $data
     */
    public function __unserialize(array $data): void
    {
        $this->adaptee = Uuid::fromString($data['uuid']);
    }
}
