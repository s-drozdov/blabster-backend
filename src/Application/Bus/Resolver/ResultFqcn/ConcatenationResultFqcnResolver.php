<?php

declare(strict_types=1);

namespace Blabster\Application\Bus\Resolver\ResultFqcn;

use Override;

final class ConcatenationResultFqcnResolver implements ResultFqcnResolverInterface
{
    private const string CLASS_NAME_RESULT_TEMPLATE = '%sResult';

    #[Override]
    public function resolve(string $cqrsElementFqcn): string
    {
        return sprintf(self::CLASS_NAME_RESULT_TEMPLATE, $cqrsElementFqcn);
    }
}
