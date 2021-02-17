<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Process;

use Aura\Router\Matcher;
use Aura\Router\Route;
use Aura\Router\Rule\Accepts;
use Aura\Router\Rule\Allows;
use Aura\Router\Rule\Host;
use Aura\Router\Rule\Path;
use Fig\Http\Message\StatusCodeInterface;
use Jnjxp\Router\Respond\FailResponderInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutingFailed extends AbstractRoutingFailed
{
    protected $fail;

    protected $matcher;

    public function __construct(FailResponderInterface $fail, Matcher $matcher)
    {
        $this->fail = $fail;
        $this->matcher = $matcher;
    }

    protected function failed(ServerRequestInterface $request) : bool
    {
        return $this->matcher->getMatchedRoute() ? false : true;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $route = $this->getFailedRoute();

        if (! $route) {
            return $this->fail->unknown($request);
        }

        switch ($route->failedRule) {
            case Allows::class:
                return $this->fail->notAllowed($request, $route->allows);
                break;
            case Accepts::class:
                return $this->fail->notAcceptable($request);
                break;
            case Host::class:
            case Path::class:
                return $this->fail->notFound($request);
                break;
            default:
                return $this->fail->unknown($request);
        }
    }

    protected function getFailedRoute() : ?Route
    {
        return $this->matcher->getFailedRoute();
    }
}
