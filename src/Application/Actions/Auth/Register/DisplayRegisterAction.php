<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;

class DisplayRegisterAction extends Action
{

    protected function action(): Response
    {
        if ($this->user() != null) {
            // Redirect to home page
            return $this->redirect('dashboard');
        }

        return $this->respondWithView('home/content.twig', []);
    }
}