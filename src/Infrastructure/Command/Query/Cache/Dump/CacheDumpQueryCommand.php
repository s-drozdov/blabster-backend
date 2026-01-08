<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Query\Cache\Dump;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Blabster\Application\UseCase\Query\Cache\Dump\CacheDumpQuery;
use Blabster\Application\UseCase\Query\Cache\Dump\CacheDumpQueryResult;

#[AsCommand(
    name: 'diagnostics:cache:dump',
    description: 'Cache health check',
)]
final class CacheDumpQueryCommand extends Command
{
    private const KEY = 'key';

    public function __construct(

        /** @var CommandBusQueryProcessor<CacheDumpQuery,CacheDumpQueryResult> $busProcessor */
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
                        bin/console diagnostics:cache:dump \
                            --%s=KEY
                    example: 
                        bin/console diagnostics:cache:dump --%s=SomeEntity.d58726ad-eafb-4659-a1b7-9c72a2a38f78
                HELPBLOCK,
                self::KEY,
                self::KEY,
            ),
        );

        $this->addOption(self::KEY, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::KEY));
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, CacheDumpQuery::class);
    }
}
