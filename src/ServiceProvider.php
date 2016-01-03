<?php

namespace Albert221\Container;

interface ServiceProvider
{
    /**
     * Provides items by adding them to container.
     *
     * @param Container $container
     */
    public function provide(Container $container);
}