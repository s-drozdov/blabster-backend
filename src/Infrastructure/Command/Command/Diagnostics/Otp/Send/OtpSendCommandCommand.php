<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Command\Diagnostics\Otp\Send;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommand;
use Blabster\Infrastructure\Bus\Processor\CommandBusCommandProcessor;
use Blabster\Application\UseCase\Command\Otp\Send\OtpSendCommandResult;

#[AsCommand(
    name: 'diagnostics:otp:send',
    description: 'Send OTP Diagnostics',
)]
final class OtpSendCommandCommand extends Command
{
    private const EMAIL = 'email';
    private const OTP_CODE = 'otp_code';

    public function __construct(
        private StringHelperInterface $stringHelper,

        /** @var CommandBusCommandProcessor<OtpSendCommand,OtpSendCommandResult> $busProcessor */
        private CommandBusCommandProcessor $busProcessor,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure()
    {
        $this->setHelp(
            sprintf(
                <<<HELPBLOCK
                    usage:
                        bin/console diagnostics:otp:send \
                            --%s=EMAIL \
                            --%s=OTP_CODE
                    example: 
                        bin/console diagnostics:otp:send --%s=test@test.com --%s=12345
                HELPBLOCK,
                self::EMAIL,
                self::OTP_CODE,
                self::EMAIL,
                self::OTP_CODE,
            ),
        );

        $this
            ->addOption(self::EMAIL, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::EMAIL))
            ->addOption(self::OTP_CODE, null, InputOption::VALUE_OPTIONAL, $this->stringHelper->snakeToHumanReadable(self::OTP_CODE))
        ;
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, OtpSendCommand::class);
    }
}
