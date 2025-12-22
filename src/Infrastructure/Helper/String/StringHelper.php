<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Helper\String;

use Override;

use function Symfony\Component\String\u;
use Webmozart\Assert\Assert;
use Blabster\Domain\Helper\String\StringHelperInterface;

final readonly class StringHelper implements StringHelperInterface
{
    private const string CACHE_SLUG_PATTERN = '%s.%s';
    private const string PASSWORD_DEFAULT_ALPHABET = 'abcdefghijklmnopqrstuvwxyz0123456789';

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
            self::CACHE_SLUG_PATTERN,
            $this->getClassShortName($class),
            $slug,
        );
    }

    #[Override]
    public function getLocalPartFromEmail(string $email): string
    {
        return current(explode('@', $email, 2));
    }

    #[Override]
    public function generateMessengerPassword(int $length, string $symbols): string
    {
        $chars = self::PASSWORD_DEFAULT_ALPHABET . $symbols;
        $password = '';

        $maxIndex = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $maxIndex)];
        }

        return $password;
    }

    #[Override]
    public function snakeToHumanReadable(string $source): string
    {
        return ucfirst(
            (string) u($source)->replace('_', ' '),
        );
    }
}
