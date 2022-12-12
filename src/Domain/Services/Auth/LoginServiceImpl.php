<?php

namespace App\Domain\Services\Auth;

use App\Domain\Auth\AuthInterface;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;
use Respect\Validation\Validator;

class LoginServiceImpl extends Service implements LoginService
{

    /**
     * @Inject
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @Inject
     * @var AuthInterface
     */
    private AuthInterface $auth;

    /**
     * {@inheritDoc}
     */
    public function login(LoginRequest $request): User
    {
        $validator = $this->validator->validate($request->getData(), [
            'email' => Validator::notBlank()->email()->length(0, 254),
            'password' => Validator::notBlank()->length(0, 128),
        ]);

        if (!$validator->isValid()) {
            throw new BadRequestException();
        }

        $data = $validator->getValues();
        $user = $this->userRepository->logUser($data['email'], $data['password']);

        // Set user to session
        $this->auth->setUser($user);

        return $user;
    }
}