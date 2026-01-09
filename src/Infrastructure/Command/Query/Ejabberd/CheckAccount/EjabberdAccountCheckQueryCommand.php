<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Query\Ejabberd\CheckAccount;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Blabster\Application\UseCase\Query\Ejabberd\CheckAccount\EjabberdAccountCheckQuery;
use Blabster\Application\UseCase\Query\Ejabberd\CheckAccount\EjabberdAccountCheckQueryResult;

#[AsCommand(
    name: 'ejabberd:account:check',
    description: 'Check ejabberd account',
)]
final class EjabberdAccountCheckQueryCommand extends Command
{
    private const string USER = 'user';
    private const string HOST = 'host';

    public function __construct(

        /** @var CommandBusQueryProcessor<EjabberdAccountCheckQuery,EjabberdAccountCheckQueryResult> $busProcessor */
        private CommandBusQueryProcessor $busProcessor,

        private StringHelperInterface $stringHelper,
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
                        bin/console ejabberd:account:check \
                            --%s=USER \
                            --%s=HOST
                    example: 
                        bin/console ejabberd:account:check --%s=test_user --%s=example.com
                HELPBLOCK,
                
                self::USER,
                self::HOST,

                self::USER,
                self::HOST,
            ),
        );

        $this
            ->addOption(self::USER, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::USER))
            ->addOption(self::HOST, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::HOST))
        ;
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, EjabberdAccountCheckQuery::class);
    }
}
