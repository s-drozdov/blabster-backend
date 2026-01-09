<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\Ejabberd\AddRosterItem;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem\EjabberdRosterItemAddCommand;
use Blabster\Application\UseCase\Command\Ejabberd\AddRosterItem\EjabberdRosterItemAddCommandHandler;

final class EjabberdRosterItemAddCommandHandlerTest extends TestCase
{
    private const string LOCALUSER = 'localuser';
    private const string LOCALHOST = 'localhost';
    private const string USER = 'user';
    private const string HOST = 'host';
    private const string NICK = 'nick';
    private const array GROUP_LIST = ['group1', 'group2'];
    private const string SUBS = 'subs';

    #[Test]
    public function testInvokeSuccess(): void
    {
        // arrange
        $query = new EjabberdRosterItemAddCommand(
            localuser: self::LOCALUSER,
            localhost: self::LOCALHOST,
            user: self::USER,
            host: self::HOST,
            nick: self::NICK,
            group_list: self::GROUP_LIST,
            subs: self::SUBS,
        );

        $ejabberSdk = $this->createMock(EjabberdSdkInterface::class);
        $ejabberSdk->expects(self::once())->method('addRosterItem');

        $handler = new EjabberdRosterItemAddCommandHandler($ejabberSdk);

        // act
        $handler($query);
    }
}
