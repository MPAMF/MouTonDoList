<?php
declare(strict_types=1);

namespace App\Application\Middleware\Auth;

use App\Application\Middleware\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class UserDisconnectedMiddleware extends Middleware
{

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $user = $request->getAttribute('user');

        if (isset($user)) {
            return $this->withInfo($this->translator->trans('AuthUserAlreadyConnected'))->redirect('dashboard', $request);
        }

        return $handler->handle($request);
    }
}
