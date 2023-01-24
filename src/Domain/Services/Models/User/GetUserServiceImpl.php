<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\User;
use App\Domain\Requests\User\GetUserRequest;
use App\Infrastructure\Repositories\UserRepository;

class GetUserServiceImpl implements GetUserService
{

    /**
     * @Inject
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @inheritDoc
     */
    public function get(GetUserRequest $request): User
    {
        $id = $request->getUserId();
        $userId = $request->getSessionUserId();

        // Maybe implement an admin system here => if admin then permission accorded
        if ($id != $userId) {
            throw new NoPermissionException();
        }

        return $this->userRepository->get($id);
    }
}