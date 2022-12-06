<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\Invitation\ListInvitationsRequest;
use App\Domain\Services\Invitation\ListInvitationsService;

class ListInvitationsServiceImpl implements ListInvitationsService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    public function list(ListInvitationsRequest $request): array
    {
        return $this->userCategoryRepository->getCategories($request->getUserId(), false);
    }

}
