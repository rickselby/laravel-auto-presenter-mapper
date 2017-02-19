<?php

namespace RickSelby\LaravelAutoPresenterMapper;

use Illuminate\Contracts\Container\Container;
use McCool\LaravelAutoPresenter\AutoPresenterServiceProvider;
use RickSelby\LaravelAutoPresenterMapper\Decorators\MapperDecorator;

class AutoPresenterMapperServiceProvider extends AutoPresenterServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerAutoPresenterMapper($this->app);
    }

    /**
     * Register the Mapper decorator.
     *
     * @param Container $app
     */
    public function registerAutoPresenterMapper(Container $app)
    {
        $app->singleton('autopresentermapper', function() {
            return new AutoPresenterMapper();
        });

        $autoPresenter = $app->make('autopresenter');
        $autoPresenter->register(new MapperDecorator($autoPresenter, $this->app->make('autopresentermapper'), $this->app));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return array_merge(parent::provides(), [
            'autopresentermapper'
        ]);
    }

}
