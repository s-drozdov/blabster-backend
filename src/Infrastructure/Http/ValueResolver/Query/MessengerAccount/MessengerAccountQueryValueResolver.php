<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver\Query\MessengerAccount;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Blabster\Application\UseCase\Query\MessengerAccount\MessengerAccountQuery;
use Blabster\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<MessengerAccountQuery>
 */
final readonly class MessengerAccountQueryValueResolver extends AbstractValueResolver
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
        return MessengerAccountQuery::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $user = $this->security->getUser();
        Assert::notNull($user);

        return new MessengerAccountQuery(
            email: $user->getUserIdentifier(),
        );
    }
}