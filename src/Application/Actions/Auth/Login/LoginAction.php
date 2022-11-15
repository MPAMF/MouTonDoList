<?php

namespace App\Application\Actions\Auth\Login;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends Action
{

    protected function action(): Response
    {
        return $this->respondWithView('');
    }

}