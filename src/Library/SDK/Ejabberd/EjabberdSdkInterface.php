<?php

declare(strict_types=1);

namespace Blabster\Library\SDK\Ejabberd;

use InvalidArgumentException;
use Blabster\Library\SDK\SdkInterface;
use Blabster\Library\SDK\Ejabberd\Request\RegisterRequestDto;
use Blabster\Library\SDK\Ejabberd\Request\CheckAccountRequestDto;
use Blabster\Library\SDK\Ejabberd\Request\AddRosterItemRequestDto;
use Blabster\Library\SDK\Ejabberd\Response\CheckAccountResponseDto;

interface EjabberdSdkInterface extends SdkInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function addRosterItem(AddRosterItemRequestDto $requestDto): void;
    
    /**
     * @throws InvalidArgumentException
     */
    public function checkAccount(CheckAccountRequestDto $requestDto): CheckAccountResponseDto;
    
    /**
     * @throws InvalidArgumentException
     */
    public function register(RegisterRequestDto $requestDto): void;
}
