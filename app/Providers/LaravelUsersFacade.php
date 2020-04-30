<?php

namespace App\Providers;

use Illuminate\Support\Facades\Facade;

class LaravelUsersFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravelusers';
    }
}
