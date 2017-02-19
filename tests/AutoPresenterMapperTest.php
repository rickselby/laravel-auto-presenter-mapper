<?php

/*
 * This file is part of Laravel Auto Presenter.
 *
 * (c) Shawn McCool <shawn@heybigname.com>
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RickSelby\Tests;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use McCool\LaravelAutoPresenter\Decorators\DecoratorInterface;
use McCool\LaravelAutoPresenter\Exceptions\PresenterNotFoundException;
use McCool\Tests\Stubs\DecoratedAtom;
use McCool\Tests\Stubs\DecoratedAtomPresenter;
use McCool\Tests\Stubs\DependencyDecoratedAtom;
use McCool\Tests\Stubs\DependencyDecoratedAtomPresenter;
use McCool\Tests\Stubs\UndecoratedAtom;
use McCool\Tests\Stubs\WronglyDecoratedAtom;
use Mockery;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;
use RickSelby\Tests\Stubs\MappedStub;
use RickSelby\Tests\Stubs\MappedStubPresenter;
use RickSelby\Tests\Stubs\UnmappedStub;

class AutoPresenterMapperTest extends AbstractTestCase
{
    /** @var AutoPresenterMapper */
    private $autoPresenterMapper;

    /**
     * @before
     */
    public function setUpProperties()
    {
        $this->autoPresenterMapper = $this->app->make(AutoPresenterMapper::class);
    }

    public function testMappingsIsCollection()
    {
        $this->assertInstanceOf(Collection::class, $this->autoPresenterMapper->getMappings());
    }

    public function testSetMapping()
    {
        $this->setMapping();

        $mappings = $this->autoPresenterMapper->getMappings();

        $this->assertEquals(1, $mappings->count());
        $this->assertEquals(MappedStub::class, $mappings->keys()->first());
        $this->assertEquals(MappedStubPresenter::class, $mappings->first());
    }

    public function testHasPresenter()
    {
        $this->setMapping();
        $this->assertTrue($this->autoPresenterMapper->hasPresenter($this->getMappedStub()));
        $this->assertFalse($this->autoPresenterMapper->hasPresenter($this->getUnmappedStub()));
    }

    public function testGetPresenter()
    {
        $this->setMapping();
        $this->assertEquals(MappedStubPresenter::class, $this->autoPresenterMapper->getPresenter($this->getMappedStub()));
        $this->assertNull($this->autoPresenterMapper->getPresenter($this->getUnmappedStub()));
    }

    protected function getMappedStub()
    {
        return new MappedStub();
    }

    protected function getUnmappedStub()
    {
        return new UnmappedStub();
    }

    protected function setMapping()
    {
        $this->autoPresenterMapper->map(MappedStub::class, MappedStubPresenter::class);
    }

}
