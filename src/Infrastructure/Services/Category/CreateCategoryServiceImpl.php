<?php

namespace App\Infrastructure\Services\Category;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Category\Requests\CreateCategoryRequest;
use App\Domain\Models\Category\Services\CreateCategoryService;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Infrastructure\Services\Service;

class CreateCategoryServiceImpl extends Service implements CreateCategoryService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    private UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * {@inheritDoc}
     */
    public function create(CreateCategoryRequest $categoryRequest): Category
    {
        $category = new Category();

        $validator = $this->validator->validate($categoryRequest->getFormData(), $category->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();

        $userId = $categoryRequest->getUserId();
        //
        $category->fromValidator($data);

        $parent = $category->getParentCategoryId() == null;

        if ($parent) {
            // owner id => parent category owner
            $category->setOwnerId($userId);
        } else {

            // Parent category isn't none, check if user has permission to create a new subCategory
            if (!$this->userCategoryRepository->exists(null, categoryId: $category->getParentCategoryId(),
                userId: $userId, accepted: true, canEdit: true)) {
                throw new NoPermissionException();
            }

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

        return $category;
    }
}