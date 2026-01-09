<?php

declare(strict_types=1);

namespace Blabster\Application\UseCase\Query\Ejabberd\CheckAccount;

use Override;
use Blabster\Application\Bus\CqrsElementInterface;
use Blabster\Library\SDK\Ejabberd\EjabberdSdkInterface;
use Blabster\Application\Bus\Query\QueryHandlerInterface;
use Blabster\Library\SDK\Ejabberd\Request\CheckAccountRequestDto;

/**
 * @implements QueryHandlerInterface<EjabberdAccountCheckQuery,EjabberdAccountCheckQueryResult>
 */
final readonly class EjabberdAccountCheckQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EjabberdSdkInterface $ejabberdSdk,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): EjabberdAccountCheckQueryResult
    {
        $requestDto = new CheckAccountRequestDto(
            user: $query->user,
            host: $query->host,
        );

        $responseDto = $this->ejabberdSdk->checkAccount($requestDto);

        return new EjabberdAccountCheckQueryResult(
            is_user_exist: $responseDto->is_user_exist,
        );
    }
}
