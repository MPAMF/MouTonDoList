<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\CreateUserRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\UserRepository;

class CreateUserServiceImpl extends Service implements CreateUserService
{

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;

    /**
     * @inheritDoc
     */
    public function create(CreateUserRequest $request): User
    {
        $user = new User();
        $validator = $this->validator->validate($request->getFormData(), $user->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $user->fromValidator($data);

        if ($this->userRepository->exists(null, $user->getEmail())) {
            // already exists
            throw new AlreadyExistsException($this->translator->trans('UserAlreadyExists'));
        }

        // Hash password
        $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));

        if (!$this->userRepository->save($user)) {
            throw new RepositorySaveException($this->translator->trans('UserCreateDBError'));
        }

        return $user;
    }
}