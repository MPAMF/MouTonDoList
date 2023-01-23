<?php

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Services\Auth\Token\TokenDecodeService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;
use Slim\Flash\Messages;
use Symfony\Component\Translation\Translator;

class TokenMiddleware extends Middleware
{
    private AuthInterface $auth;
    private TokenDecodeService $tokenDecodeService;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        Translator      $translator,
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

        try {
            $user = $this->tokenDecodeService->decode($header[0]);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($request);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        return $handler->handle($request->withAttribute('user', $user));
    }
}