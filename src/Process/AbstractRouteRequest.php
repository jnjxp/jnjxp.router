<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Process;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractRouteRequest implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->match($request)
            ? $this->matched($request)
            : $this->unmatched($request);

        return $handler->handle($request);
    }

    abstract protected function match(ServerRequestInterface $request) : bool;

    abstract protected function matched(ServerRequestInterface $request) : ServerRequestInterface;

    protected function unmatched(ServerRequestInterface $request) : ServerRequestInterface
    {
        return $request;
    }
}
