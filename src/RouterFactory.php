<?php

declare(strict_types=1);

namespace Jnjxp\Router;

use Aura\Router\Map;
use Aura\Router\Matcher;
use Aura\Router\RouterContainer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;

class RouterFactory
{
    public function __invoke(ContainerInterface $container, string $name)
    {
        switch ($name) {
            case RouterContainer::class:
                return $this->newRouterContainer($container);
                break;
            case RouterConfig::class:
                return $this->newRouterConfig($container);
                break;
            case Respond\FailResponderInterface::class:
            case Respond\FailResponder::class:
                return $this->newFailResponder($container);
                break;
            case Process\RouteRequest::class:
                return $this->newRouteRequest($container);
                break;
            case Process\RoutingFailed::class:
                return $this->newRoutingFailed($container);
                break;
            default:
                throw new ServiceNotFoundException($name);
                break;
        }
    }

    public function newRouterContainer() : RouterContainer
    {
        return new RouterContainer();
    }

    public function newRouterConfig() : callable
    {
        return new RouterConfig();
    }

    public function newFailResponder(ContainerInterface $container) : Respond\FailResponderInterface
    {
        return new Respond\FailResponder($container->get(ResponseFactoryInterface::class));
    }

    public function newRouteRequest(ContainerInterface $container) : MiddlewareInterface
    {
        return new Process\RouteRequest($container->get(Matcher::class));
    }

    public function newRoutingFailed(ContainerInterface $container) : MiddlewareInterface
    {
        return new Process\RoutingFailed(
            $container->get(Respond\FailResponderInterface::Class),
            $container->get(Matcher::class)
        );
    }
}
