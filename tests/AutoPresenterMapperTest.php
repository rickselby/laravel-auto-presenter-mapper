<?php

namespace RickSelby\Tests;

use Illuminate\Support\Collection;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;
use RickSelby\Tests\Stubs\MappedStub;
use RickSelby\Tests\Stubs\MappedStubPresenter;
use RickSelby\Tests\Stubs\UnmappedStub;

class AutoPresenterMapperTest extends AbstractTestCase
{
    /** @var AutoPresenterMapper */
    private $autoPresenterMapper;

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $this->autoPresenterMapper = $app->make(AutoPresenterMapper::class);
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

    public function testSetMappingAsArray()
    {
        $this->setMappingAsArray();

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

    protected function setMappingAsArray()
    {
        $this->autoPresenterMapper->map([MappedStub::class => MappedStubPresenter::class]);
    }
}
