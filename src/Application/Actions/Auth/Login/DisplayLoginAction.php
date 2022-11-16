<?php

namespace App\Application\Actions\Auth\Login;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DisplayLoginAction extends Action
{

    protected function action(): Response
    {
        if ($this->user() != null) {
            // Redirect to home page
            return $this->withInfo('Already connected!')->redirect('dashboard');
        }

        return $this->respondWithView('home/content.twig', [
            'content' => 'login',
        ]);
    }
}