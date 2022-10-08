<?php

namespace RickSelby\Tests\Functional;

use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;
use RickSelby\Tests\AbstractTestCase;
use RickSelby\Tests\Stubs\MappedStub;
use RickSelby\Tests\Stubs\MappedStubPresenter;

class ViewDataTest extends AbstractTestCase
{
    /**
     * Setup the application environment.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));
    }

    public function testBasicSetup()
    {
        // Set up the mapping
        /** @var AutoPresenterMapper $mapper */
        $mapper = app('autopresentermapper');
        $mapper->map(MappedStub::class, MappedStubPresenter::class);

        // make a new dummy model
        $model = new MappedStub();

        // set the foo attribute
        $model->foo = 'hi';

        // create a new view, with the model
        $view = $this->app['view']->make('stubs::test')->withModel($model);

        // check nothing has been modified yet
        $this->assertInstanceOf(MappedStub::class, $view->model);
        $this->assertSame('hi', $view->model->foo);

        // render the view
        $view->render();

        // check that the model was decorated
        $this->assertInstanceOf(MappedStubPresenter::class, $view->model);
        $this->assertSame('hi there', $view->model->foo);

        // render the view again
        $view->render();

        // check everything is still the same
        $this->assertInstanceOf(MappedStubPresenter::class, $view->model);
        $this->assertSame('hi there', $view->model->foo);
    }
}
