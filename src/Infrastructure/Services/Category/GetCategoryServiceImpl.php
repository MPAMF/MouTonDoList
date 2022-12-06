<?php

namespace App\Infrastructure\Services\Category;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Category\Requests\GetCategoryRequest;
use App\Domain\Models\Category\Services\GetCategoryService;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;

class GetCategoryServiceImpl implements GetCategoryService
{

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * {@inheritDoc}
     */
    public function get(GetCategoryRequest $request): Category
    {
        $id = $request->getCategoryId();
        $userId = $request->getUserId();
        $category = $this->categoryRepository->get($id);

        $parent = $category->getParentCategoryId() == null;

        // Check if user has permission to delete
        if ($category->getOwnerId() != $userId) {

            if ($parent) {
                throw new NoPermissionException();
            }

            if ($request->isCanEdit()) {
                if (!$this->userCategoryRepository->exists(null, categoryId: $id,
                    userId: $userId, accepted: true, canEdit: true)) {
                    throw new NoPermissionException();
                }
            } else {
                if (!$this->userCategoryRepository->exists(null, categoryId: $id,
                    userId: $userId, accepted: true)) {
                    throw new NoPermissionException();
                }
            }

        }

        return $category;
    }
}