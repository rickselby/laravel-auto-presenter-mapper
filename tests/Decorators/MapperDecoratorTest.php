<?php

namespace RickSelby\Tests\Decorators;

use GrahamCampbell\TestBench\AbstractTestCase;
use Illuminate\Contracts\Container\Container;
use McCool\LaravelAutoPresenter\AutoPresenter;
use McCool\LaravelAutoPresenter\Exceptions\PresenterNotFoundException;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;
use RickSelby\LaravelAutoPresenterMapper\Decorators\MapperDecorator;
use RickSelby\Tests\Stubs\MappedStub;
use RickSelby\Tests\Stubs\MappedStubPresenter;
use RickSelby\Tests\Stubs\UnmappedStub;

class MapperDecoratorTest extends AbstractTestCase
{
    /** @var MapperDecorator */
    private $decorator;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $autoPresenter;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $autoPresenterMapper;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $container;

    /**
     * @before
     */
    public function setUpProperties()
    {
        $this->autoPresenter = $this->createMock(AutoPresenter::class);
        $this->autoPresenterMapper = $this->createMock(AutoPresenterMapper::class);
        $this->container = $this->createMock(Container::class);

        $this->container->method('make')
            ->with(MappedStubPresenter::class)
            ->willReturn(new MappedStubPresenter());

        $this->decorator = new MapperDecorator(
            $this->autoPresenter,
            $this->autoPresenterMapper,
            $this->container
        );
    }

    public function testCanDecoratePresenter()
    {
        $mappedStub = new MappedStub();
        $this->autoPresenterMapper->method('hasPresenter')->willReturn(true);
        $this->assertTrue($this->decorator->canDecorate($mappedStub));
    }

    public function testCannotDecorateNonPresentable()
    {
        $unmappedStub = new UnmappedStub();
        $this->autoPresenterMapper->method('hasPresenter')->willReturn(false);
        $this->assertFalse($this->decorator->canDecorate($unmappedStub));
    }

    public function testWillReturnPresenter()
    {
        $model = $this->createMock(MappedStub::class);
        $model->method('getRelations')->willReturn([]);
        $this->autoPresenterMapper->method('getPresenter')
            ->willReturn(MappedStubPresenter::class);

        $this->assertInstanceOf(MappedStubPresenter::class, $this->decorator->decorate($model));
    }

    public function testShouldHandleRelations()
    {
        $model = $this->createMock(MappedStub::class);
        $relations = ['blah'];

        $this->autoPresenter->method('decorate')->with($relations[0])->willReturn('foo');
        $this->autoPresenterMapper->method('getPresenter')
            ->willReturn(MappedStubPresenter::class);

        $model->method('getRelations')->willReturn($relations);

        // Check the relation is updated as expected
        $model->expects($this->once())->method('setRelation')->with(0, 'foo');

        $this->decorator->decorate($model);
    }

    public function testWillThrowExceptionIfPresenterDoesNotExist()
    {
        $this->expectException(PresenterNotFoundException::class);

        $model = $this->createMock(MappedStub::class);

        $this->autoPresenterMapper->method('getPresenter')->willReturn('ClassDoesNotExist');

        $model->method('getRelations')->willReturn([]);

        $this->decorator->decorate($model);
    }

    public function testWillNotPresentDecoratable()
    {
        $model = $this->createMock(MappedStub::class);
        $model->method('getRelations')->willReturn([]);

        $this->autoPresenterMapper->method('getPresenter')->willReturn(null);

        $this->assertInstanceOf(MappedStub::class, $this->decorator->decorate($model));
    }
}
