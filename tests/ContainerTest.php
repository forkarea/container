<?php

use Albert221\Container\Container;

require 'ServiceProviderImplementation.php';

class ContainerTest extends PHPUnit_Framework_TestCase
{
    public function testAddServiceProvider()
    {
        $container = new Container;
        $provider = new ServiceProviderImplementation;
        $container->addProvider($provider);

        $example = $container->get('example');

        $this->assertEquals('test', $example);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument specified; item's name must be a string, integer given.
     */
    public function testAddWithNonStringName()
    {
        $container = new Container;
        $container->add(1, 'test');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument specified; item with name of "example" already exists.
     */
    public function testAddWithAlreadyExistingName()
    {
        $container = new Container;
        $container->add('example', 'test');

        $container->add('example', 'another value');
    }

    /**
     * @expectedException \Albert221\Container\Exception\NotFoundException
     * @expectedExceptionMessage Item with name of "example" does not exists.
     */
    public function testGetWithNonExistingName()
    {
        $container = new Container;

        $container->get('example');
    }

    public function testGetWithValue()
    {
        $container = new Container;
        $container->add('example', 'test');

        $example = $container->get('example');

        $this->assertEquals('test', $example);
    }

    public function testGetWithCallable()
    {
        $container = new Container;
        $container->add('example', function() {
            return 'test';
        });

        $example = $container->get('example');

        $this->assertEquals('test', $example);
    }

    public function testHas()
    {
        $container = new Container;

        $this->assertFalse($container->has('example'));

        $container->add('example', 'test');

        $this->assertTrue($container->has('example'));
    }
}
