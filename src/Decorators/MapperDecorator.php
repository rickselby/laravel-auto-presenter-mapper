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

namespace RickSelby\LaravelAutoPresenterMapper\Decorators;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;
use McCool\LaravelAutoPresenter\AutoPresenter;
use McCool\LaravelAutoPresenter\Decorators\DecoratorInterface;
use McCool\LaravelAutoPresenter\Exceptions\PresenterNotFoundException;
use RickSelby\LaravelAutoPresenterMapper\AutoPresenterMapper;

class MapperDecorator implements DecoratorInterface
{
    /**
     * The auto presenter instance.
     *
     * @var \McCool\LaravelAutoPresenter\AutoPresenter
     */
    protected $autoPresenter;

    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The auto presenter mapper instance.
     *
     * @var AutoPresenterMapper
     */
    private $autoPresenterMapper;

    /**
     * Create a new atom decorator.
     *
     * @param \McCool\LaravelAutoPresenter\AutoPresenter $autoPresenter
     * @param AutoPresenterMapper                        $autoPresenterMapper
     * @param \Illuminate\Contracts\Container\Container  $container
     */
    public function __construct(AutoPresenter $autoPresenter, AutoPresenterMapper $autoPresenterMapper, Container $container)
    {
        $this->autoPresenter = $autoPresenter;
        $this->autoPresenterMapper = $autoPresenterMapper;
        $this->container = $container;
    }

    /**
     * Can the subject be decorated?
     *
     * @param mixed $subject
     *
     * @return bool
     */
    public function canDecorate($subject)
    {
        return $this->autoPresenterMapper->hasPresenter($subject);
    }

    /**
     * Decorate a given subject.
     *
     * @param object $subject
     *
     * @throws PresenterNotFoundException
     *
     * @return object
     */
    public function decorate($subject)
    {
        if (is_object($subject)) {
            $subject = clone $subject;
        }

        if ($subject instanceof Model) {
            foreach ($subject->getRelations() as $relationName => $model) {
                $subject->setRelation($relationName, $this->autoPresenter->decorate($model));
            }
        }

        if (!class_exists($presenter = $this->autoPresenterMapper->getPresenter($subject))) {
            throw new PresenterNotFoundException($presenter);
        }

        return $this->container->make($presenter)->setWrappedObject($subject);
    }

    /**
     * Get the auto presenter instance.
     *
     * @codeCoverageIgnore
     *
     * @return \McCool\LaravelAutoPresenter\AutoPresenter
     */
    public function getAutoPresenter()
    {
        return $this->autoPresenter;
    }

    /**
     * Get the mapper instance.
     *
     * @codeCoverageIgnore
     *
     * @return AutoPresenterMapper
     */
    public function getAutoPresenterMapper()
    {
        return $this->autoPresenterMapper;
    }

    /**
     * Get the container instance.
     *
     * @codeCoverageIgnore
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
