<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\Reflection;

use Override;
use ReflectionClass;
use ReflectionProperty;
use ReflectionNamedType;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Blabster\Library\Helper\Reflection\ReflectionHelperInterface;

final readonly class ReflectionHelper implements ReflectionHelperInterface
{
    private const string ERROR_CANNOT_GET_TYPE = 'Cannot get a type of property %s of class %s';

    #[Override]
    public function getPropertyType(string $objectType, string $property): string
    {
        $reflection = new ReflectionProperty($objectType, $property);

        $type = $reflection->getType();
        
        if ($type instanceof ReflectionNamedType) {
            return $type->getName();
        }
        
        throw new InvalidArgumentException(
            sprintf(
                self::ERROR_CANNOT_GET_TYPE,
                $property,
                $objectType,
            ),
        );
    }

    #[Override]
    public function getNestedPropertyType(string $objectType, string $nestedProperty): string
    {
        $levelList = explode('.', $nestedProperty);

        foreach ($levelList as $level) {
            /** @var class-string $objectType */
            $objectType = $this->getPropertyType($objectType, $level);
        }

        return $objectType;
    }

    #[Override]
    public function assertEqualObjects(object $a, object $b): void
    {
        Assert::same(get_class($a), get_class($b));

        $reflection = new ReflectionClass($a);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $valueA = $property->getValue($a);
            $valueB = $property->getValue($b);

            Assert::eq($valueA, $valueB);
        }
    }

    #[Override]
    public function getClassShortName(object|string $target): string
    {
        return new ReflectionClass($target)->getShortName();
    }

    #[Override]
    public function setProperty(object $object, string $property, mixed $value): void
    {
        $reflection = new ReflectionClass($object);

        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        $property->setValue($object, $value);
    }
}
