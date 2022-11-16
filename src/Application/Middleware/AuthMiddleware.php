<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Auth\AuthInterface;
use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Flash\Messages;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthMiddleware extends Middleware
{
    private AuthInterface $auth;

    public function __construct(ResponseFactoryInterface $responseFactory,
                                TranslatorInterface      $translator,
                                Messages                 $messages,
                                AuthInterface            $auth)
    {
        parent::__construct($responseFactory, $translator, $messages);
        $this->auth = $auth;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$this->auth->check()) {
            return $this->withError($this->translator->trans('AuthUserNotConnected'))
                ->redirect('account.login', $request);
        }

        try {
            $user = $this->auth->user();
        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthUserNotFoundError'))
                ->redirect('account.login', $request);
        }

        return $handler->handle($request->withAttribute('user', $user));
    }
}
