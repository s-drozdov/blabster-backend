<?php

declare(strict_types=1);

use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommandHandler;

return [
    OtpSendCommand::class => OtpSendCommandHandler::class,
];
