<?php

namespace App\Application\Actions\Auth\Logout;

use App\Application\Actions\Action;
use App\Domain\Auth\AuthInterface;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutAction extends Action
{

    /**
     * @Inject
     * @var AuthInterface
     */
    private AuthInterface $auth;

    protected function action(): Response
    {
        $this->auth->removeUser();

        return $this->withSuccess($this->translator->trans('AuthLogOutSuccess'))
            ->redirect('home');
    }

}