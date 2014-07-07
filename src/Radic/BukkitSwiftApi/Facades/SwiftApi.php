<?php namespace Radic\BukkitSwiftApi\Facades;

use Illuminate\Support\Facades\Facade;

class SwiftApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Radic\BukkitSwiftApi\SwiftApi';
    }
}