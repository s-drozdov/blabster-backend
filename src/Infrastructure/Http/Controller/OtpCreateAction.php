<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\Controller;

use Override;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Blabster\Infrastructure\Bus\CqrsBusInterface;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommandResult;
use Blabster\Infrastructure\Http\RequestResolver\RequestResolverInterface;
use Webmozart\Assert\Assert;

final readonly class OtpCreateAction implements ActionInterface
{
    public function __construct(
        private RequestResolverInterface $requestResolver,

        /** @var CqrsBusInterface<OtpSendCommand,OtpSendCommandResult> $bus */
        private CqrsBusInterface $bus,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        /** @var OtpSendCommand $element */
        $element = $this->requestResolver->resolve(OtpSendCommand::class, $request, $args);

        $rawBody = json_encode($this->bus->execute($element));
        Assert::string($rawBody);
        $response->getBody()->write($rawBody);
        
        return $response;
    }
}
