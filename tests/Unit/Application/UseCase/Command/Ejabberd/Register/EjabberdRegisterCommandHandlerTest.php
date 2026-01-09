<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Command\Ejabberd\Register;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\UseCase\Command\Ejabberd\Register\EjabberdRegisterCommand;
use Blabster\Application\UseCase\Command\Ejabberd\Register\EjabberdRegisterCommandHandler;

final class EjabberdRegisterCommandHandlerTest extends TestCase
{
    private const string USER = 'user';
    private const string HOST = 'host';
    private const string PASSWORD = 'password';

    #[Test]
    public function testInvokeSuccess(): void
    {
        // arrange
        $query = new EjabberdRegisterCommand(
            user: self::USER,
            host: self::HOST,
            password: self::PASSWORD,
        );

        $ejabberSdk = $this->createMock(EjabberdSdkInterface::class);
        $ejabberSdk->expects(self::once())->method('register');

        $handler = new EjabberdRegisterCommandHandler($ejabberSdk);

        // act
        $handler($query);
    }
}
