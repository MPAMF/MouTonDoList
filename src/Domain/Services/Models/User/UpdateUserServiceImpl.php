<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\GetUserRequest;
use App\Domain\Requests\User\UpdateUserRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;
use Respect\Validation\Validator;

class UpdateUserServiceImpl extends Service implements UpdateUserService
{

    /**
     * @Inject
     * @var GetUserService
     */
    private GetUserService $getUserService;

    /**
     * @Inject
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @inheritDoc
     */
    public function update(UpdateUserRequest $request): User
    {
        $user = $this->getUserService->get(new GetUserRequest(
            userId: $request->getUserId(),
            sessionUserId: $request->getSessionUserId()
        ));

        $rules = $user->getValidatorRules();
        $patch = $request->getMethod() == 'PATCH';

        // Set the rules to optional
        if ($patch) {

            // ignore empty patch
            if(empty($request->getFormData()))
                return $user;

            $rules = collect($rules)->map(function ($value) {
                return Validator::optional($value);
            })->toArray();
        }

        $validator = $this->validator->validate($request->getFormData(), $rules);

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();

        if (!$patch || isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (!$patch || isset($data['password'])) {
            $password = $data['password'];
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        }

        if (!$patch || isset($data['image_path'])) {
            $user->setImagePath($data['image_path']);
        }

        if (!$patch || isset($data['theme'])) {
            $user->setTheme($data['theme']);
        }

        if (!$patch || isset($data['language'])) {
            $user->setLanguage($data['language']);
        }

        if (!$this->userRepository->save($user)) {
            throw new RepositorySaveException($this->translator->trans('UserUpdateDBError'));
        }

        return $user;
    }
}