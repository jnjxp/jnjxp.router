<?php

declare(strict_types = 1);

namespace Jnjxp\Router;

use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;

class RouterConfig
{
    const LOGGER_FACTORY = 'router-logger-factory';
    const ROUTE_FACTORY  = 'router-route-factory';
    const MAP_FACTORY    = 'router-map-factory';
    const MAP_BUILDER    = 'router-map-builder';

    protected $settings = [
        self::LOGGER_FACTORY => 'setLoggerFactory',
        self::ROUTE_FACTORY  => 'setRouteFactory',
        self::MAP_FACTORY    => 'setMapFactory',
        self::MAP_BUILDER    => 'setMapBuilder'
    ];

    public function __invoke(ContainerInterface $container, RouterContainer $routerContainer) : RouterContainer
    {
        foreach ($this->settings as $service => $method) {
            if ($container->has($service)) {
                $routerContainer->$method($container->get($service));
            }
        }
        return $routerContainer;
    }
}
