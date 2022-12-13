<?php

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;
use Slim\Flash\Messages;
use Symfony\Contracts\Translation\TranslatorInterface;

class TokenMiddleware extends Middleware
{
    private AuthInterface $auth;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        TranslatorInterface      $translator,
        Messages                 $messages,
        AuthInterface            $auth
    )
    {
        parent::__construct($responseFactory, $translator, $messages);
        $this->auth = $auth;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if(!$request->hasHeader('Authorization'))
        {
            throw new HttpForbiddenException($request);
           // return $this->responseFactory->createResponse(401);
        }

        $header = $request->getHeader('Authorization');

        if(!isset($header[0]))
        {
            throw new HttpForbiddenException($request);
        }

        $token = base64_decode($header[0]);

        if(!$token)
        {
            throw new HttpForbiddenException($request);
        }

        // TODO: Get user

        return $handler->handle($request);
    }
}