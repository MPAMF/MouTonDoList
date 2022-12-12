<?php

namespace App\Domain\Services\Invitation;

use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Infrastructure\Repositories\UserCategoryRepository;
use DI\Annotation\Inject;

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
