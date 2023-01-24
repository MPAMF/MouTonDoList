<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Infrastructure\Repositories\UserCategoryRepository;

class GetInvitationServiceImpl implements GetInvitationService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * {@inheritDoc}
     */
    public function get(GetInvitationRequest $request): UserCategory
    {
        $with = $request->getWith();
        $userId = $request->getUserId();

        if (!isset($with)) {
            $with = ['category', 'user'];
        } else {
            if (!array_key_exists('category', $with)) {
                $with[] = 'category';
            }

            if (!array_key_exists('user', $with)) {
                $with[] = 'user';
            }
        }

        $userCategory = $this->userCategoryRepository->get($request->getInvitationId(), $with);

        if ($userCategory->getCategory() == null) {
            throw new CategoryNotFoundException();
        }

        // Not user check owner of category
        if ($userCategory->getUserId() != $userId && $userCategory->getCategory()->getOwnerId() != $userId) {
            throw new NoPermissionException();
        }

        return $userCategory;
    }
}
