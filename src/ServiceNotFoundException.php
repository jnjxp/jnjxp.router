<?php

declare(strict_types = 1);

namespace Jnjxp\Router;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
