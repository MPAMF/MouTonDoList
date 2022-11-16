<?php

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

abstract class Middleware implements MiddlewareInterface
{
    protected ResponseFactoryInterface $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    public function redirect(Request $request, string $url): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $this->responseFactory->createResponse()
            ->withHeader('Location', $routeParser->urlFor($url))
            ->withStatus(302);
    }

}