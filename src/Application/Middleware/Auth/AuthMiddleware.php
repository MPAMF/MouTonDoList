<?php
declare(strict_types=1);

namespace App\Application\Middleware\Auth;

use App\Application\Middleware\Middleware;
use App\Domain\Auth\AuthInterface;
use App\Domain\Models\User\UserNotFoundException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * This middleware check's if there's an active user session
 * And sets user attribute to request
 *
 * If you want to check if user is logged in, just use UserConnectedMiddleware
 */
class AuthMiddleware extends Middleware
{
    private AuthInterface $auth;

    public function __construct(
        ResponseFactoryInterface $responseFactory,
        TranslatorInterface      $translator,
        Messages                 $messages,
        AuthInterface            $auth
    ) {
        parent::__construct($responseFactory, $translator, $messages);
        $this->auth = $auth;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {

        if ($this->auth->check()) {
            try {
                $user = $this->auth->user();
                return $handler->handle($request->withAttribute('user', $user));
            } catch (UserNotFoundException) {
            }
        }

        return $handler->handle($request);
    }
}
