<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Invitation\CreateInvitationRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use App\Infrastructure\Repositories\UserRepository;
use DI\Annotation\Inject;

class CreateInvitationServiceImpl extends Service implements CreateInvitationService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserRepository
     */
    public UserRepository $userRepository;


    /**
     * {@inheritDoc}
     */
    public function create(CreateInvitationRequest $request): UserCategory
    {
        $userCategory = new UserCategory();
        $validator = $this->validator->validate($request->getFormData(), $userCategory->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        //
        $userCategory->fromValidator($data);
        $userCategory->setCategory($this->categoryRepository->get($userCategory->getCategoryId()));

        if ($userCategory->getCategory()->getOwnerId() != $request->getUserId()) {
            throw new NoPermissionException();
        }

        $userCategory->setUser($this->userRepository->get($userCategory->getUserId()));

        // Already exists
        if ($this->userCategoryRepository->exists(
            null, categoryId: $userCategory->getCategoryId(), userId: $userCategory->getUserId()
        )) {
            throw new AlreadyExistsException($this->translator->trans('InvitationAlreadyExists'));
        }

        if (!$this->userCategoryRepository->save($userCategory)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('InvitationCreateDBError'));
        }

        return $userCategory;
    }
}
