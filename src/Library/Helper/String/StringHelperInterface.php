<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\String;

use Blabster\Library\Helper\HelperInterface;

interface StringHelperInterface extends HelperInterface
{
    /**
     * @param class-string|object $class
     */
    public function getClassShortName(string|object $class): string;

    /**
     * @param class-string|object $class
     */
    public function getSlugForClass(string $slug, string|object $class): string;

    public function getLocalPartFromEmail(string $email): string;

    public function generateMessengerPassword(int $length, string $symbols): string;
}
