<?php

namespace RickSelby\LaravelAutoPresenterMapper;

use Illuminate\Support\Collection;

class AutoPresenterMapper
{
    /** @var Collection */
    private $mappings;

    public function __construct()
    {
        $this->mappings = new Collection();
    }

    /**
     * Add another presenter mapping
     *
     * @param $class
     * @param $presenter
     */
    public function map($class, $presenter = null)
    {
        if (is_array($class))
        {
            foreach($class AS $model => $present) {
                $this->mappings->put($model, $present);
            }
        } else {
            $this->mappings->put($class, $presenter);
        }
    }

    /**
     * Check if the given class has a presenter mapped
     *
     * @param $class
     *
     * @return bool
     */
    public function hasPresenter($class)
    {
        return is_object($class) && $this->mappings->has(get_class($class));
    }

    /**
     * Get the presenter for the given class
     *
     * @param $class
     *
     * @return mixed
     */
    public function getPresenter($class)
    {
        return $this->mappings->get(get_class($class));
    }

    /**
     * Get the full list of mappings
     *
     * @codeCoverageIgnore
     *
     * @return Collection
     */
    public function getMappings()
    {
        return $this->mappings;
    }

}