<?php

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use App\Domain\Services\Auth\Token\TokenDecodeService;
use App\Infrastructure\Repositories\UserRepository;
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
    private TokenDecodeService $tokenDecodeService;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        TranslatorInterface      $translator,
        Messages                 $messages,
        AuthInterface            $auth,
        TokenDecodeService $tokenDecodeService,
    )
    {
        parent::__construct($responseFactory, $translator, $messages);
        $this->auth = $auth;
        $this->tokenDecodeService = $tokenDecodeService;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader('Authorization')) {
            throw new HttpForbiddenException($request);
        }

        $header = $request->getHeader('Authorization');

        if (!isset($header[0])) {
            throw new HttpForbiddenException($request);
        }

        $user = $this->tokenDecodeService->decode($header[0]);

        return $handler->handle($request->withAttribute('user', $user));
    }
}