<?php

use Albert221\Container\Container;
use Albert221\Container\ServiceProvider;

class ServiceProviderImplementation implements ServiceProvider
{
    public function provide(Container $container)
    {
        $container->add('example', 'test');
    }
}