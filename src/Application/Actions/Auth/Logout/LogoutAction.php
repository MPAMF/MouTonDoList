<?php

namespace App\Application\Actions\Auth\Logout;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class LogoutAction extends Action
{

    protected function action(): Response
    {
        return $this->redirect('home');
    }

}