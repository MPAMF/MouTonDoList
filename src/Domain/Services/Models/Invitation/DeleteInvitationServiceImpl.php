<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Infrastructure\Repositories\UserCategoryRepository;

class DeleteInvitationServiceImpl implements DeleteInvitationService
{
    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var GetInvitationService
     */
    public GetInvitationService $getInvitationService;

    /**
     * {@inheritDoc}
     */
    public function delete(DeleteInvitationRequest $request): bool
    {
        $invitation = $this->getInvitationService->get(new GetInvitationRequest(
            userId: $request->getUserId(),
            invitationId: $request->getInvitationId()
        ));

        return $this->userCategoryRepository->delete($invitation) != 0;
    }
}
