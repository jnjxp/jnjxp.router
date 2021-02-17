<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Process;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class AbstractRoutingFailed implements MiddlewareInterface, RequestHandlerInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->failed($request)) {
            return $this->handle($request);
        }

        return $handler->handle($request);
    }

    abstract public function handle(ServerRequestInterface $request) : ResponseInterface;

    abstract protected function failed(ServerRequestInterface $request) : bool;
}
