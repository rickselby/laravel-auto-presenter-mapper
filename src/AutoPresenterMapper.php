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
     * Add another presenter mapping.
     *
     * @param string|array $class
     * @param string|null $presenter [optional]
     */
    public function map($class, $presenter = null)
    {
        if (is_array($class)) {
            foreach ($class as $model => $present) {
                $this->mappings->put($model, $present);
            }
        } else {
            $this->mappings->put($class, $presenter);
        }
    }

    /**
     * Add a decoratable model (it has no presenter, but its relations can be decorated).
     *
     * @param $class
     */
    public function decorate($class)
    {
        $this->map($class, null);
    }

    /**
     * Remove a presenter mapping.
     *
     * @param string $class
     */
    public function remove($class)
    {
        if ($this->mappings->has($class)) {
            $this->mappings->forget($class);
        }
    }

    /**
     * Check if the given class has a presenter mapped.
     *
     * @param string $class
     *
     * @return bool
     */
    public function hasPresenter($class)
    {
        return is_object($class) && $this->mappings->has(get_class($class));
    }

    /**
     * Get the presenter for the given class.
     *
     * @param string $class
     *
     * @return mixed
     */
    public function getPresenter($class)
    {
        return $this->mappings->get(get_class($class));
    }

    /**
     * Get the full list of mappings.
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
