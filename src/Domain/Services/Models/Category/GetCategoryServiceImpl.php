<?php

namespace App\Domain\Services\Models\Category;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionService;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;

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
     * @Inject
     * @var UserCategoryCheckPermissionService
     */
    public UserCategoryCheckPermissionService $userCategoryExistsService;

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

            // Throws NoPermissionException if no permission
            $this->userCategoryExistsService->exists(new UserCategoryCheckPermissionRequest(
                userId: $userId,
                categoryId: $id,
                canEdit: $request->isCanEdit()
            ));
        }

        return $category;
    }
}
