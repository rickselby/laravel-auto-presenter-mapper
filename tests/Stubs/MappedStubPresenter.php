<?php

namespace RickSelby\Tests\Stubs;

use McCool\LaravelAutoPresenter\BasePresenter;

class MappedStubPresenter extends BasePresenter
{
    public function foo()
    {
        return $this->getWrappedObject()->foo.' there';
    }
}
