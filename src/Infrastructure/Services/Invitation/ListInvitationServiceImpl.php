<?php

namespace App\Infrastructure\Services\Invitation;

use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\Invitation\ListInvitationRequest;
use App\Domain\Services\Invitation\ListInvitationService;

class ListInvitationServiceImpl implements ListInvitationService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * {@inheritDoc}
     */
    public function list(ListInvitationRequest $request): array
    {
        return $this->userCategoryRepository->getCategories($request->getUserId(), false, with: ['owner']);
    }

}
