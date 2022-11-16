<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;

class SessionMiddleware extends Middleware
{
    private Guard $guard;
    private Messages $messages;

    public function __construct(ResponseFactoryInterface $responseFactory, Guard $guard, Messages $messages)
    {
        parent::__construct($responseFactory);
        $this->guard = $guard;
        $this->messages = $messages;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            session_start();
            // Change storage to session storage
            $this->guard->setStorage();
            $this->messages->__construct($_SESSION);
            $request = $request->withAttribute('session', $_SESSION);
        }

        return $handler->handle($request);
    }
}
