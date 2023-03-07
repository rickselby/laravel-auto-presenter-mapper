<?php

namespace RickSelby\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapperServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected static function getServiceProviderClass(): string
    {
        return AutoPresenterMapperServiceProvider::class;
    }
}
