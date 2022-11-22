<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Auth\AuthAction;
use App\Domain\User\User;
use App\Domain\UserCategory\UserCategoryNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;

class RegisterAction extends AuthAction
{

    protected function action(): Response
    {
        $validator = $this->validator->validate($this->request, [
            'email' => Validator::notBlank()->email()->length(0,254),
            'pseudo' => Validator::notBlank()->length(0,64),
            'password' => Validator::notBlank()->regex('/[A-Z]/')->regex('/[a-z]/')
                ->regex('/[1-9]/')->regex('/[-_*.!?#@&]/')->length(0,128),
            'password-conf' => Validator::equals($_POST['password']),
        ]);

        if (!$validator->isValid()) {
            return $this->withError($this->translator->trans('AuthRegisterFailed'))
                ->respondWithView('home/content.twig',[]);
        }

        $data = $this->getFormData();
        try {
            if($this->userRepository->exists($data['email'])){
                return $this->withError($this->translator->trans('AuthRegisterUserExist'))
                    ->respondWithView('home/content.twig',[]);
            }

            $user = new User();
            $user->setEmail($data['email']);
            $user->setUsername($data['pseudo']);
            $user->setPassword(password_hash($data['password'],PASSWORD_DEFAULT));

            if(!($this->userRepository->save($user))){
                return $this->withError($this->translator->trans('AuthRegisterUserExist'))
                    ->respondWithView('home/content.twig',[]);
            }

        } catch (UserCategoryNotFoundException) {
            return $this->withError($this->translator->trans('AuthRegisterFailed'))
                ->respondWithView('home/content.twig',[]);
        }

        return $this->withSuccess($this->translator->trans('AuthRegisterSuccess'))
            ->redirect('account.login');
    }
}