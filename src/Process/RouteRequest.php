<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Process;

use Aura\Router\Matcher;
use Aura\Router\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteRequest extends AbstractRouteRequest
{
    protected $matcher;

    protected $route_attr = Route::class;
    protected $handler_attr = 'request-handler';

    protected $with = [
        'withRoute',
        'withAttributes',
        'withHandler'
    ];

    public function __construct(Matcher $matcher)
    {
        $this->matcher = $matcher;
    }

    protected function match(ServerRequestInterface $request) : bool
    {
        $route = $this->matcher->match($request);
        return $route ? true : false;
    }

    protected function getMatchedRoute() : Route
    {
        return $this->matcher->getMatchedRoute();
    }

    protected function matched(ServerRequestInterface $request) : ServerRequestInterface
    {
        $route = $this->getMatchedRoute();

        foreach ($this->with as $method) {
            $request = $this->$method($request, $route);
        }

        return $request;
    }

    protected function withRoute(ServerRequestInterface $request, Route $route) : ServerRequestInterface
    {
        return $request->withAttribute($this->route_attr, $route);
    }

    protected function withAttributes(ServerRequestInterface $request, Route $route) : ServerRequestInterface
    {
        foreach ($route->attributes as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }
        return $request;
    }

    protected function withHandler(ServerRequestInterface $request, Route $route) : ServerRequestInterface
    {
        return $request->withAttribute($this->handler_attr, $route->handler);
    }
}
