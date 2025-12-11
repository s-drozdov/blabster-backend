<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\String;

use Blabster\Library\Helper\HelperInterface;

interface StringHelperInterface extends HelperInterface
{
    public function kebabToHumanReadable(string $source): string;

    public function snakeToHumanReadable(string $source): string;

    public function snakeToPascal(string $source): string;

    public function nestedToSquareBrackets(string $source): string;

    /**
     * @param class-string|object $class
     */
    public function getClassShortName(string|object $class): string;

    /**
     * @param class-string|object $class
     */
    public function getSlugForClass(string $slug, string|object $class): string;
}
