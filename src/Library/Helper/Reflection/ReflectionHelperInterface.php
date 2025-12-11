<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\Reflection;

use ReflectionException;
use InvalidArgumentException;
use Blabster\Library\Helper\HelperInterface;

interface ReflectionHelperInterface extends HelperInterface
{
    /**
     * @param class-string $objectType
     * 
     * @throws InvalidArgumentException
     */
    public function getPropertyType(string $objectType, string $property): string;

    /**
     * @param class-string $objectType
     * 
     * @throws InvalidArgumentException
     */
    public function getNestedPropertyType(string $objectType, string $nestedProperty): string;

    /**
     * @throws InvalidArgumentException
     */
    public function assertEqualObjects(object $a, object $b): void;

    /**
     * @param object|class-string $target
     */
    public function getClassShortName(object|string $target): string;

    /**
     * @throws ReflectionException
     */
    public function setProperty(object $object, string $property, mixed $value): void;
}
