<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\UserCategoryRepository;
use DI\Annotation\Inject;

class UpdateInvitationServiceImpl extends Service implements UpdateInvitationService
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
    public function update(UpdateInvitationRequest $request): UserCategory
    {
        $userCategory = $this->getInvitationService->get(new GetInvitationRequest(
            userId: $request->getUserId(),
            invitationId: $request->getInvitationId()
        ));

        $validator = $this->validator->validate($request->getFormData(), $userCategory->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $newUserCategory = new UserCategory();
        $newUserCategory->fromValidator($data);

        // Not owner => can only accept
        // Owner => can only change canEdit
        if ($userCategory->getUserId() == $request->getUserId()) {
            $userCategory->setAccepted($userCategory->isAccepted() || $newUserCategory->isAccepted());
        } elseif ($userCategory->getCategory()->getOwnerId() == $request->getUserId()) {
            $userCategory->setCanEdit($newUserCategory->isCanEdit());
        }

        // Useless to check if something was deleted
        if (!$this->userCategoryRepository->save($userCategory)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('InvitationUpdateDBError'));
        }

        return $userCategory;
    }
}
