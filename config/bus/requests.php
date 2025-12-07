<?php

declare(strict_types=1);

use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Blabster\Infrastructure\Http\RequestResolver\OtpRequestResolver;

return [
    OtpSendCommand::class => OtpRequestResolver::class,
];
