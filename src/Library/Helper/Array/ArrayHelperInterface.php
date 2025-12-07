<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\Array;

use Blabster\Library\Helper\HelperInterface;

interface ArrayHelperInterface extends HelperInterface
{
    /**
     * @param mixed[] $array
     * 
     * @return array-key|null
     */
    public function getKeyOfItem(array $array, mixed $item): int|string|null;

    /**
     * @param mixed[] $array
     * 
     * @return string|null
     */
    public function getInnerType(array $array): ?string;

    /**
     * @param array<mixed> $array
     * @param string $nestedPath
     */
    public function normalizePath(array &$array, string $nestedPath): void;
}
