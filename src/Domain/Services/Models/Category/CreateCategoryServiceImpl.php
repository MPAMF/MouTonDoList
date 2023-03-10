<?php

namespace App\Domain\Services\Models\Category;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Category\CreateCategoryRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionService;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;

class CreateCategoryServiceImpl extends Service implements CreateCategoryService
{

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryCheckPermissionService
     */
    public UserCategoryCheckPermissionService $userCategoryCheckPermissionService;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * {@inheritDoc}
     */
    public function create(CreateCategoryRequest $request): Category
    {
        $category = new Category();
        $validator = $this->validator->validate($request->getFormData(), $category->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $userId = $request->getUserId();
        //
        $category->fromValidator($data);

        $parent = $category->getParentCategoryId() == null;

        if ($parent) {
            // owner id => parent category owner
            $category->setOwnerId($userId);
        } else {
            // Parent category isn't none, check if user has permission to create a new subCategory
            // Throws exception if no permission
            $this->userCategoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
                userId: $userId,
                categoryId: $category->getParentCategoryId(),
            ));

            // set subcategory owner to the owner of the parent category
            try {
                $parentCategory = $this->categoryRepository->get($category->getParentCategoryId());
            } catch (CategoryNotFoundException) {
                throw new BadRequestException($this->translator->trans('ParentCategoryNotFound'));
            }

            $category->setOwnerId($parentCategory->getOwnerId());
        }

        // TODO: Maybe check two same names?

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('CategoryCreateDBError'));
        }

        if ($parent) {
            // Don't forget to create usercategory
            $userCategory = new UserCategory();
            $userCategory->setAccepted(true);
            $userCategory->setCanEdit(true);
            $userCategory->setCategoryId($category->getId());
            $userCategory->setUserId($userId);
            $this->userCategoryRepository->save($userCategory);
        }

        return $category;
    }
}
