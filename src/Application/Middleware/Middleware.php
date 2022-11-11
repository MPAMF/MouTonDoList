<?php

namespace App\Application\Middleware;

use App\Infrastructure\Auth\Auth;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

abstract class Middleware implements MiddlewareInterface
{

    protected ResponseFactoryInterface $responseFactory;
    protected Auth $auth;


    public function __construct(Auth $auth, ResponseFactoryInterface $responseFactory)
    {
        $this->auth = $auth;
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