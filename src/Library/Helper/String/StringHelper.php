<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\String;

use Override;

use Webmozart\Assert\Assert;
use function Symfony\Component\String\u;
use Blabster\Library\Helper\String\StringHelperInterface;

final readonly class StringHelper implements StringHelperInterface
{
    private const string TRANSLATION_PATTERN = '%s:%s';

    #[Override]
    public function kebabToHumanReadable(string $source): string
    {
        return ucfirst(
            (string) u($source)->replace('-', ' '),
        );
    }

    #[Override]
    public function snakeToHumanReadable(string $source): string
    {
        return ucfirst(
            (string) u($source)->replace('_', ' '),
        );
    }

    #[Override]
    public function snakeToPascal(string $source): string
    {
        return implode(
            '',
            array_map(
                fn (string $word) => ucfirst($word),
                explode('_', $source),
            ),
        );
    }

    #[Override]
    public function nestedToSquareBrackets(string $source): string
    {
        $levelList = explode('.', $source);

        return array_reduce(
            $levelList,
            fn (string $acc, string $cur) => $acc . sprintf('[%s]', $cur),
            '',
        );
    }

    #[Override]
    public function getClassShortName(string|object $class): string
    {
        $fqcn = (is_string($class)) ? $class : $class::class;

        $pos = strrpos($fqcn, '\\');
        Assert::notFalse($pos);

        return substr($fqcn, $pos + 1);
    }

    #[Override]
    public function getSlugForClass(string $slug, string|object $class): string
    {
        return sprintf(
            self::TRANSLATION_PATTERN,
            $this->getClassShortName($class),
            $slug,
        );
    }
}
