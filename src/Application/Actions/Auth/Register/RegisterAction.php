<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Action;
use App\Application\Actions\Auth\AuthAction;
use App\Domain\User\UserNotFoundException;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;
use function PHPUnit\Framework\equalTo;
use function PHPUnit\Framework\objectEquals;

class RegisterAction extends AuthAction
{

    protected function action(): Response
    {
        $validator = $this->validator->validate($this->request, [
            'email' => Validator::notBlank()->email(),
            'pseudo' => Validator::notBlank(),
            'password' => Validator::notBlank()->regex('/[A-Z]')->regex('/[-_*.!?#@&]'),
            'password-conf' => Validator::notBlank(),
        ]);

        if (!$validator->isValid()) {
            return $this->respondWithView('home/content.twig');
        }

        $data = $this->getFormData();
        if(!$data['password'] == ($data['password-conf'])){
            return $this->withError($this->translator->trans('AuthRegisterConfirm'))->redirect('account.register');
        }

        try {
            if($this->userRepository->exists($data['email'])){
                return $this->withError($this->translator->trans('AuthRegisterUserExist'))->redirect('account.register');
            }

            $user = new Uses();
            $user->setEmail($data['email']);
            $user->setUsername($data['pseudo']);
            $user->setPassword(password_hash($data['password'],PASSWORD_DEFAULT));

            if($this->userRepository->save($user)){
                return $this->withError($this->translator->trans('AuthRegisterUserExist'))->redirect('account.register');
            }

        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthRegisterFailed'))->redirect('account.register');
        }

        return $this->withSuccess($this->translator->trans('AuthRegisterSuccess'))
            ->redirect('account.login');
    }

}