<?php

namespace App\Application\Actions\Auth\Logout;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DisplayLogoutAction extends Action
{

    protected function action(): Response
    {
        if ($this->user() != null) {
            // Redirect to home page
            return $this->respondWithView('pages/dashboard',[]);
        }

        return $this->redirect('account.login');
    }
}