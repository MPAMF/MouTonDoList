<?php

namespace App\Application\Actions\Auth\Logout;

use App\Application\Actions\Auth\AuthAction;
use App\Domain\Models\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutAction extends AuthAction
{

    protected function action(): Response
    {
        try {
            // Set user to session
            $this->auth->removeUser();

        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthLogOutFailed'))->redirect('dashboard');
        }

        return $this->withSuccess($this->translator->trans('AuthLogOutSuccess'))
            ->redirect('home');
    }

}