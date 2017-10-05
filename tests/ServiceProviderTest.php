<?php

namespace RickSelby\Tests;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testAutoPresenterMapperIsInjectable()
    {
        $this->assertIsInjectable(AutoPresenterMapper::class);
    }
}
