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
            'email' => Validator::notBlank()->email(),
            'password' => Validator::notBlank(),
        ]);

        if (!$validator->isValid()) {
            return $this->respondWithView('home/content.twig', [
                'content' => 'login',
            ]);
        }

        $data = $this->getFormData();

        try {
            $this->userRepository->logUser($data['email'], $data['password']);
        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthLoginFailed'))->redirect('account.login');
        }

        return $this->withSuccess($this->translator->trans('AuthLoginSuccess'))
            ->redirect('dashboard');
    }
}
