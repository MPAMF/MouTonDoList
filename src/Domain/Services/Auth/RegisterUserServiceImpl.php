<?php

namespace App\Domain\Services\Auth;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Models\User\User;
use App\Domain\Requests\Auth\RegisterRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\UserRepository;
use Respect\Validation\Validator;

class RegisterUserServiceImpl extends Service implements RegisterUserService
{

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;

    /**
     * {@inheritDoc}
     */
    public function register(RegisterRequest $request): User
    {
        $validator = $this->validator->validate($request->getData(), [
            'email' => Validator::notBlank()->email()->length(0, 254),
            'username' => Validator::notBlank()->length(0, 64),
            'password' => Validator::notBlank()->regex('/[A-Z]/')->regex('/[a-z]/')
                ->regex('/[1-9]/')->regex('/[-_*.!?#@&]/')->length(6, 128),
            'password-conf' => Validator::equals($request->getPassword()),
        ]);

        if (!$validator->isValid()) {
            throw new BadRequestException($this->translator->trans('AuthRegisterFailed'));
        }

        $data = $validator->getValues();

        if ($this->userRepository->exists(email: $data['email'])) {
            throw new BadRequestException($this->translator->trans('AuthRegisterUserExist'));
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setUsername($data['username']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        if (!($this->userRepository->save($user))) {
            throw new RepositorySaveException($this->translator->trans('AuthRegisterFailed'));
        }

        return $user;
    }
}