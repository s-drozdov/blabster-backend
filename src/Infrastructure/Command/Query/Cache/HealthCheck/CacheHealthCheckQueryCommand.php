<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Query\Cache\HealthCheck;

use Override;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Infrastructure\Bus\Processor\CommandBusQueryProcessor;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQuery;
use Blabster\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQueryResult;

#[AsCommand(
    name: 'diagnostics:cache:health-check',
    description: 'Cache health check',
)]
final class CacheHealthCheckQueryCommand extends Command
{
    public function __construct(

        /** @var CommandBusQueryProcessor<CacheHealthCheckQuery,CacheHealthCheckQueryResult> $busProcessor */
        private CommandBusQueryProcessor $busProcessor,
    ) {
        parent::__construct();
    }

    #[Override]
    protected function configure()
    {
        $this->setHelp(
            <<<HELPBLOCK
                usage:
                    bin/console diagnostics:cache:health-check
            HELPBLOCK,
        );
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->busProcessor->process($input, $output, CacheHealthCheckQuery::class);
    }
}
