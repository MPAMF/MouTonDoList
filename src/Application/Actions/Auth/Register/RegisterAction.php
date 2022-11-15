<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends Action
{

    protected function action(): Response
    {
        return $this->respondWithView('');
    }

}