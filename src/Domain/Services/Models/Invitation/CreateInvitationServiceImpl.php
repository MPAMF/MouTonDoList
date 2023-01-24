<?php

namespace App\Domain\Services\Models\Invitation;

use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\BadRequestException;
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
     * @throws BadRequestException
     */
    public function create(CreateInvitationRequest $request): UserCategory
    {
        $userCategory = new UserCategory();
        $validator = $this->validator->validate($request->getFormData(), $userCategory->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();

        if(empty($data['user_id']) && empty($data['email']))
            throw new BadRequestException($this->translator->trans('UserIdOrEmailExpected'));

        if(empty($data['user_id']) && !empty($data['email']))
            $data['user_id'] = 0;

        $userCategory->fromValidator($data);

        $userCategory->setCategory($this->categoryRepository->get($userCategory->getCategoryId()));

        // should be a parent category
        if($userCategory->getCategory()->getParentCategoryId() != NULL)
        {
            throw new BadRequestException($this->translator->trans('CategoryNotParentCategory'));
        }

        if ($userCategory->getCategory()->getOwnerId() != $request->getUserId()) {
            throw new NoPermissionException();
        }

        if(empty($data['user_id']) && !empty($data['email']))
        {
            $user = $this->userRepository->getByEmail($data['email']);
            $data['user_id'] = empty($user) ? 0 : $user->getId();
        }

        $userCategory->setUser($this->userRepository->get($userCategory->getUserId()));

        // Already exists
        if ($this->userCategoryRepository->exists(
            null, categoryId: $userCategory->getCategoryId(), userId: $userCategory->getUserId()
        )) {
            throw new AlreadyExistsException($this->translator->trans('InvitationAlreadyExists'));
        }

        $userCategory->setAccepted(false);

        if (!$this->userCategoryRepository->save($userCategory)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('InvitationCreateDBError'));
        }

        return $userCategory;
    }
}
