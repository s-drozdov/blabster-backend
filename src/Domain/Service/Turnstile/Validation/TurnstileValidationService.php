<?php

declare(strict_types=1);

namespace Blabster\Domain\Service\Turnstile\Validation;

use Blabster\Domain\Repository\TurnsnileResultRepositoryInterface;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Blabster\Domain\Service\ServiceInterface;

final readonly class TurnstileValidationService implements ServiceInterface
{
    private const string ERROR_INVALID_TOKEN = 'Validation was not passed.';

    public function __construct(
        private TurnsnileResultRepositoryInterface $turnsnileResultRepository,
    ) {
        /*_*/
    }

    /**
     * @throws InvalidArgumentException
     */
    public function perform(string $token): void
    {
        $result = $this->turnsnileResultRepository->getByUuid($token);

        Assert::notFalse($result->isSuccess(), self::ERROR_INVALID_TOKEN);
    }
}
