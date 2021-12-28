<?php


namespace KaqazStudio\LaravelMobileAuth\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * Class LaravelMobileAuthFacade
 *
 * @see \KaqazStudio\LaravelMobileAuth\
 * @package KaqazStudio\LaravelMobileAuth\Facade
 */
class LaravelMobileAuthFacade extends Facade
{

    protected static function getFacadeAccessor(): string
    {
        return 'LaravelMobileAuth';
    }

}
