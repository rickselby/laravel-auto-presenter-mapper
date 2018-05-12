<?php

namespace RickSelby\Tests;

use RickSelby\Tests\Stubs\MappedStub;
use RickSelby\Tests\Stubs\UnmappedStub;
use RickSelby\Tests\Stubs\MappedStubPresenter;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;

class AutoPresenterMapperTest extends AbstractTestCase
{
    /** @var AutoPresenterMapper */
    private $autoPresenterMapper;

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $this->autoPresenterMapper = $app->make(AutoPresenterMapper::class);
    }

    public function testSetMappingHasMapping()
    {
        $this->setMapping();
        $this->assertTrue($this->autoPresenterMapper->hasPresenter(new MappedStub()));
    }

    public function testSetMappingDoesNotSetForUnmapped()
    {
        $this->setMapping();
        $this->assertFalse($this->autoPresenterMapper->hasPresenter(new UnmappedStub()));
    }

    public function testSetMappingReturnsCorrectClass()
    {
        $this->setMapping();
        $this->assertEquals(MappedStubPresenter::class, $this->autoPresenterMapper->getPresenter(new MappedStub()));
    }

    public function testSetMappingAsArray()
    {
        $this->setMappingAsArray();
        $this->assertTrue($this->autoPresenterMapper->hasPresenter(new MappedStub()));
    }

    public function testRemoveMapping()
    {
        $this->setMapping();
        $this->autoPresenterMapper->remove(MappedStub::class);
        $this->assertFalse($this->autoPresenterMapper->hasPresenter(new MappedStub()));
    }

    public function testDecorating()
    {
        $this->setDecorating();
        $this->assertTrue($this->autoPresenterMapper->hasPresenter(new MappedStub()));
    }

    public function testDecoratingReturnsNoClass()
    {
        $this->setDecorating();
        $this->assertNull($this->autoPresenterMapper->getPresenter(new MappedStub()));
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

    protected function setDecorating()
    {
        $this->autoPresenterMapper->decorate(MappedStub::class);
    }
}
