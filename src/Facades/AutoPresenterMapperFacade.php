<?php

namespace RickSelby\LaravelAutoPresenterMapper\Facades;

use Illuminate\Support\Facades\Facade;

class AutoPresenterMapperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'autopresentermapper';
    }
}
