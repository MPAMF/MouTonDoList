<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Requests\Invitation\ListInvitationRequest;
use App\Infrastructure\Repositories\UserCategoryRepository;
use DI\Annotation\Inject;

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
