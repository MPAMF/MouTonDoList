<?php

namespace App\Domain\Services\Models\User;

use App\Domain\Requests\User\DeleteUserRequest;
use App\Domain\Requests\User\GetUserRequest;
use App\Infrastructure\Repositories\UserRepository;

class DeleteUserServiceImpl implements DeleteUserService
{

    /**
     * @Inject
     * @var GetUserService
     */
    public GetUserService $getUserService;

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;

    /**
     * @inheritDoc
     */
    public function delete(DeleteUserRequest $request): bool
    {
        $user = $this->getUserService->get(new GetUserRequest(
            userId: $request->getUserId(),
            sessionUserId: $request->getSessionUserId()
        ));

        return $this->userRepository->delete($user);
    }
}