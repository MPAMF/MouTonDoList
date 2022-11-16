<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware extends Middleware
{
    protected AuthInterface $auth;

    public function __construct(ResponseFactoryInterface $responseFactory, AuthInterface $auth)
    {
        parent::__construct($responseFactory);
        $this->auth = $auth;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$this->auth->check()) {
            return $this->redirect($request, 'account.login');
        }

        try {
            $user = $this->auth->user();
        } catch (UserNotFoundException) {
            return $this->redirect($request, 'account.login');
        }

        return $handler->handle($request->withAttribute('user', $user));
    }
}
