<?php

namespace App\Application\Handlers;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

trait RedirectHandler
{

    public function redirect(string $url, Request $request = null): ResponseInterface
    {
        if(!isset($request)) $request = $this->request;
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $this->responseFactory->createResponse()
            ->withHeader('Location', $routeParser->urlFor($url))
            ->withStatus(302);
    }

}