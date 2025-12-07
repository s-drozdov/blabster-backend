<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\RequestResolver;

use Override;
use Psr\Http\Message\ServerRequestInterface;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Webmozart\Assert\Assert;

final readonly class OtpRequestResolver implements RequestResolverInterface
{
    #[Override]
    public function resolve(string $cqrsElementFqcn, ServerRequestInterface $request, array $args): OtpSendCommand
    {
        /** @var array<array-key,mixed> $parsedBody */
        $parsedBody = $request->getParsedBody();

        Assert::keyExists($parsedBody, 'email');
        Assert::keyExists($parsedBody, 'proof_of_work_id');
        Assert::keyExists($parsedBody, 'proof_of_work_result');
        Assert::keyExists($parsedBody, 'fingerprint');
        Assert::keyExists($parsedBody, 'turnstile_token');

        Assert::string($parsedBody['email']);
        Assert::string($parsedBody['proof_of_work_id']);
        Assert::string($parsedBody['proof_of_work_result']);
        Assert::string($parsedBody['fingerprint']);
        Assert::string($parsedBody['turnstile_token']);

        return new OtpSendCommand(
            email: $parsedBody['email'],
            proof_of_work_id: $parsedBody['proof_of_work_id'],
            proof_of_work_result: $parsedBody['proof_of_work_result'],
            fingerprint: $parsedBody['fingerprint'],
            turnstile_token: $parsedBody['turnstile_token'],
        );
    }
}
