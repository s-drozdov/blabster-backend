<?php

declare(strict_types=1);

namespace Blabster\Library\Collection;

/**
 * Getting inner type fqcn for serialization or null in case of simple types
 */
interface InnerTypeInterface
{   
    public function getInnerType(): ?string;
}
