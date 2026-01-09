<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Command\Ejabberd\Register;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Infrastructure\Bus\Processor\CommandBusCommandProcessor;
use Blabster\Application\UseCase\Command\Ejabberd\Register\EjabberdRegisterCommand;
use Blabster\Application\UseCase\Command\Ejabberd\Register\EjabberdRegisterCommandResult;

#[AsCommand(
    name: 'ejabberd:account:register',
    description: 'Register ejabberd account',
)]
final class EjabberdAccountRegisterCommandCommand extends Command
{
    private const string USER = 'user';
    private const string HOST = 'host';
    private const string PASSWORD = 'password';

    public function __construct(
        private StringHelperInterface $stringHelper,

        /** @var CommandBusCommandProcessor<EjabberdRegisterCommand,EjabberdRegisterCommandResult> $busProcessor */
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
                        bin/console ejabberd:account:register \
                            --%s=USER \
                            --%s=HOST \
                            --%s=PASSWORD
                    example: 
                        bin/console ejabberd:account:register --%s=user --%s=host --%s=password
                HELPBLOCK,

                self::USER,
                self::HOST,
                self::PASSWORD,

                self::USER,
                self::HOST,
                self::PASSWORD,
            ),
        );

        $this
            ->addOption(self::USER, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::USER))
            ->addOption(self::HOST, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::HOST))
            ->addOption(self::PASSWORD, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::PASSWORD))
        ;
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, EjabberdRegisterCommandResult::class);
    }
}
