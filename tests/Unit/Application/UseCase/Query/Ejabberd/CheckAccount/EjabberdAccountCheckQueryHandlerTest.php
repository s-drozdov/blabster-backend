<?php

declare(strict_types=1);

namespace Blabster\Tests\Unit\Application\UseCase\Query\Ejabberd\CheckAccount;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Blabster\Application\UseCase\Query\Ejabberd\CheckAccount\EjabberdAccountCheckQuery;
use Blabster\Application\UseCase\Query\Ejabberd\CheckAccount\EjabberdAccountCheckQueryHandler;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Library\SDK\Ejabberd\Response\CheckAccountResponseDto;

final class EjabberdAccountCheckQueryHandlerTest extends TestCase
{
    private const string USER = 'user';
    private const string HOST = 'host';

    #[Test]
    public function testInvokeSuccess(): void
    {
        // arrange
        $query = new EjabberdAccountCheckQuery(
            user: self::USER,
            host: self::HOST,
        );

        $responseDto = new CheckAccountResponseDto(
            is_user_exist: true,
        );

        $ejabberSdk = $this->createMock(EjabberdSdkInterface::class);
        $ejabberSdk->expects(self::once())->method('checkAccount')->willReturn($responseDto);

        $handler = new EjabberdAccountCheckQueryHandler($ejabberSdk);

        // act
        $result = $handler($query);

        //assert
        $this->assertTrue($result->is_user_exist);
    }
}
