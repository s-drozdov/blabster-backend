<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Command\Command\Ejabberd\AddRosterItem;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Blabster\Domain\Helper\String\StringHelperInterface;
use Blabster\Library\SDK\Ejabberd\Enum\RosterSubscriptionStatus;
use Blabster\Infrastructure\Bus\Processor\CommandBusCommandProcessor;
use Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem\EjabberdRosterItemAddCommand;
use Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem\EjabberdRosterItemAddCommandResult;

#[AsCommand(
    name: 'ejabberd:roster-item:add',
    description: 'Add roster item (contact) to ejabberd account',
)]
final class EjabberdRosterItemAddCommandCommand extends Command
{
    private const string LOCALUSER = 'localuser';
    private const string LOCALHOST = 'localhost';
    private const string USER = 'user';
    private const string HOST = 'host';
    private const string NICK = 'nick';
    private const string GROUP_LIST = 'group_list';
    private const string SUBS = 'subs';

    public function __construct(
        private StringHelperInterface $stringHelper,

        /** @var CommandBusCommandProcessor<EjabberdRosterItemAddCommand,EjabberdRosterItemAddCommandResult> $busProcessor */
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
                        bin/console ejabberd:roster-item:add \
                            --%s=LOCALUSER # username which contact list must be updated \
                            --%s=LOCALHOST # hostname of user which contact list must be updated \
                            --%s=USER # contact username \
                            --%s=HOST # contact hostname \
                            --%s=NICK # contact displayed nickname \
                            --%s=GROUP1 # contact group if needed (optional) \
                            --%s=SUBS # subscription can be one of: none|from|to|both
                    example: 
                        bin/console ejabberd:roster-item:add --%s=user --%s=host --%s=contact_user --%s=contact_host --%s=contact_nick --%s=both [ --%s=group1 ]
                HELPBLOCK,

                self::LOCALUSER,
                self::LOCALHOST,
                self::USER,
                self::HOST,
                self::NICK,
                self::GROUP_LIST,
                self::SUBS,

                self::LOCALUSER,
                self::LOCALHOST,
                self::USER,
                self::HOST,
                self::NICK,
                self::SUBS,
                self::GROUP_LIST,
            ),
        );

        $this
            ->addOption(self::LOCALUSER, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::LOCALUSER))
            ->addOption(self::LOCALHOST, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::LOCALHOST))
            ->addOption(self::USER, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::USER))
            ->addOption(self::HOST, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::HOST))
            ->addOption(self::NICK, null, InputOption::VALUE_REQUIRED, $this->stringHelper->snakeToHumanReadable(self::NICK))
            ->addOption(self::GROUP_LIST, null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, $this->stringHelper->snakeToHumanReadable(self::GROUP_LIST))
            ->addOption(
                self::SUBS, 
                null, 
                InputOption::VALUE_REQUIRED, 
                $this->stringHelper->snakeToHumanReadable(self::SUBS), 
                null, 
                array_map(fn (RosterSubscriptionStatus $case) => $case->value, RosterSubscriptionStatus::cases()),
            )
        ;
    }

    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Assert::string($input->getOptions()[self::SUBS]);
        RosterSubscriptionStatus::from($input->getOptions()[self::SUBS]);

        return $this->busProcessor->process($input, $output, EjabberdRosterItemAddCommand::class);
    }
}
