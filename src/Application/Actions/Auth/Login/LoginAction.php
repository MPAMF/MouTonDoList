<?php

namespace App\Application\Actions\Auth\Login;

use App\Application\Actions\Auth\AuthAction;
use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;

class LoginAction extends AuthAction
{

    protected function action(): Response
    {
        $validator = $this->validator->validate($this->request, [
            'email' => Validator::notBlank()->email()->length(0,254),
            'password' => Validator::notBlank()->length(0,128),
        ]);

        if (!$validator->isValid()) {
            return $this->respondWithView('home/content.twig', []);
        }

        $data = $this->getFormData();

        try {
            $user = $this->userRepository->logUser($data['email'], $data['password']);
        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthLoginFailed'))->redirect('account.login');
        }

        // Set user to session
        $this->auth->setUser($user);

        return $this->withSuccess($this->translator->trans('AuthLoginSuccess'))
            ->redirect('dashboard');
    }
}
