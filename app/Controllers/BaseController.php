<?php 

namespace Tuiter\Controllers;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    /**
     * Container de dependencias
     *
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}