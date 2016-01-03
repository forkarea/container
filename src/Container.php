<?php

namespace Albert221\Container;

use Albert221\Container\Exception\NotFoundException;
use InvalidArgumentException;

class Container
{
    /**
     * @var array Collection of dependencies.
     */
    private $collection = [];

    /**
     * Runs specified provider.
     *
     * @param ServiceProvider $provider
     */
    public function addProvider(ServiceProvider $provider)
    {
        $provider->provide($this);
    }

    /**
     * Adds item to container.
     *
     * @param string $name
     * @param mixed $item
     * @throws InvalidArgumentException when name is not a string or when item with specified name already exists.
     */
    public function add($name, $item)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException(sprintf('Invalid argument specified; item\'s name must be a string, %s given.', gettype($name)));
        }

        if ($this->has($name)) {
            throw new InvalidArgumentException(sprintf('Invalid argument specified; item with name of "%s" already exists.', $name));
        }

        $this->collection[$name] = $item;
    }

    /**
     * Return item with specified name.
     *
     * @param string $name
     * @return mixed
     * @throws NotFoundException when item can not be found.
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new NotFoundException(sprintf('Item with name of "%s" does not exists.', $name));
        }

        $item = $this->collection[$name];

        return (is_callable($item)) ? call_user_func($item, $this) : $item;
    }

    /**
     * Returns true if the container has item with specified name, returns false otherwise.
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->collection[$name]);
    }
}