<?php

declare(strict_types = 1);

namespace Jnjxp\Router\Respond;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class FailResponder implements FailResponderInterface
{
    protected $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function notAllowed(ServerRequestInterface $request, array $allows = []) : ResponseInterface
    {
        return $this
            ->createResponse(self::STATUS_METHOD_NOT_ALLOWED)
            ->withHeader('Allow', implode(', ', $allows));
    }

    public function notAcceptable(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->createResponse(self::STATUS_NOT_ACCEPTABLE);
    }

    public function notFound(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->createResponse(self::STATUS_NOT_FOUND);
    }

    public function unknown(ServerRequestInterface $request) : ResponseInterface
    {
        return $this->createResponse(self::STATUS_INTERNAL_SERVER_ERROR);
    }

    protected function createResponse(int $code) : ResponseInterface
    {
        return $this->responseFactory->createResponse($code);
    }
}
