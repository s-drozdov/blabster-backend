<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Query\MessengerAccount\Get;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Blabster\Application\UseCase\Query\MessengerAccount\Get\MessengerAccountGetQuery;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<MessengerAccountGetQuery>
 */
final readonly class MessengerAccountGetQueryValueResolver extends AbstractValueResolver
{
    public function __construct(
        private Security $security,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return MessengerAccountGetQuery::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $user = $this->security->getUser();
        Assert::notNull($user);

        return new MessengerAccountGetQuery(
            email: $user->getUserIdentifier(),
        );
    }
}