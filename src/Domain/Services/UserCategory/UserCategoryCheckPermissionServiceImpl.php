<?php

namespace App\Domain\Services\UserCategory;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use DI\Annotation\Inject;

class UserCategoryCheckPermissionServiceImpl implements UserCategoryCheckPermissionService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * {@inheritDoc}
     */
    public function exists(UserCategoryCheckPermissionRequest $request): void
    {

        $userId = $request->getUserId();
        $categoryId = $request->getCategoryId();

        if ($request->isCanEdit()) {
            if ($request->isCheckAccepted()) {
                if (!$this->userCategoryRepository->exists(
                    null,
                    categoryId: $categoryId,
                    userId: $userId,
                    accepted: $request->isAccepted(),
                    canEdit: true
                )) {
                    throw new NoPermissionException();
                }
            } elseif (!$this->userCategoryRepository->exists(
                null,
                categoryId: $categoryId,
                userId: $userId,
                canEdit: true
            )) {
                throw new NoPermissionException();
            }
        } else {
            if ($request->isCheckAccepted()) {
                if (!$this->userCategoryRepository->exists(
                    null,
                    categoryId: $categoryId,
                    userId: $userId,
                    accepted: $request->isAccepted()
                )) {
                    throw new NoPermissionException();
                }
            } elseif (!$this->userCategoryRepository->exists(null, categoryId: $categoryId)) {
                throw new NoPermissionException();
            }
        }
    }
}
