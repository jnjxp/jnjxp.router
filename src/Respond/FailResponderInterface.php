<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Respond;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Fig\Http\Message\StatusCodeInterface;

interface FailResponderInterface extends StatusCodeInterface
{
    public function notAllowed(ServerRequestInterface $request, array $allows = []) : ResponseInterface;

    public function notAcceptable(ServerRequestInterface $request) : ResponseInterface;

    public function notFound(ServerRequestInterface $request) : ResponseInterface;

    public function unknown(ServerRequestInterface $request) : ResponseInterface;
}
