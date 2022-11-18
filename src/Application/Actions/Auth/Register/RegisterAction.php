<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Action;
use App\Application\Actions\Auth\AuthAction;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends AuthAction
{

    protected function action(): Response
    {
        return $this->respondWithView('');
    }

}