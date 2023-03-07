<?php

namespace RickSelby\Tests\Facades;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;
use RickSelby\LaravelAutoPresenterMapper\Facades\AutoPresenterMapperFacade as Facade;
use RickSelby\Tests\AbstractTestCase;

class AutoPresenterMapperTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'autopresentermapper';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected static function getFacadeClass(): string
    {
        return Facade::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected static function getFacadeRoot(): string
    {
        return AutoPresenterMapper::class;
    }
}
