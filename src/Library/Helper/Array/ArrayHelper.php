<?php

declare(strict_types=1);

namespace Blabster\Library\Helper\Array;

use Override;
use Blabster\Library\Enum\PhpType;
use Blabster\Library\Helper\Array\ArrayHelperInterface;

final readonly class ArrayHelper implements ArrayHelperInterface
{
    #[Override]
    public function getKeyOfItem(array $array, mixed $item): int|string|null
    {
        $key = null;

        foreach ($array as $key => $value) {
            if ($value == $item) {
                return $key;
            }
        }
        
        return null;
    }

    #[Override]
    public function getInnerType(array $array): ?string
    {
        if (empty($array)) {
            return null;
        }

        $item = current($array);
        $type = gettype($item);

        if ($type === PhpType::object->value) {
            $type = get_debug_type($item);
        }

        return $type;
    }

    #[Override]
    public function normalizePath(array &$array, string $nestedPath): void
    {
        $levelList = explode('.', $nestedPath);

        array_pop($levelList);

        $current =& $array;

        foreach ($levelList as $level) {
            if (!isset($current[$level]) || !is_array($current[$level])) {
                $current[$level] = [];
            }

            $current =& $current[$level];
        }
    }
}
