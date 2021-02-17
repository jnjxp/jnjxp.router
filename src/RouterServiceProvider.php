<?php

declare(strict_types = 1);

namespace Jnjxp\Router;

use Aura\Router\Generator;
use Aura\Router\Map;
use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use Interop\Container\ServiceProviderInterface;

class RouterServiceProvider implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            Map::class                    => [RouterContainer::class, 'getMap'],
            Matcher::class                => [RouterContainer::class, 'getMatcher'],
            Generator::class              => [RouterContainer::class, 'getGenerator'],
            RouterConfig::class           => RouterFactory::class,
            Respond\FailResponderInterface::class => RouterFactory::class,
            Process\RouteRequest::class           => RouterFactory::class,
            Process\RoutingFailed::class          => RouterFactory::class
        ];
    }

    public function getExtensions()
    {
        return [RouterContainer::class => [RouterConfig::class]];
    }
}
