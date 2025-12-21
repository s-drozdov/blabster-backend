<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Turnstile;

use InvalidArgumentException;
use Blabster\Library\SDK\SdkInterface;
use Blabster\Library\SDK\Turnstile\Response\TurnstileResultDto;

interface TurnstileSdkInterface extends SdkInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function getResult(string $turnsnileToken, ?string $clientRemoteIp = null): TurnstileResultDto;
}
