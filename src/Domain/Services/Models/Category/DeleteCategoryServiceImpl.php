<?php

namespace App\Domain\Services\Models\Category;

use App\Domain\Requests\Category\DeleteCategoryRequest;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Infrastructure\Repositories\CategoryRepository;

class DeleteCategoryServiceImpl implements DeleteCategoryService
{

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var GetCategoryService
     */
    public GetCategoryService $getCategoryService;

    /**
     * {@inheritDoc}
     */
    public function delete(DeleteCategoryRequest $request): bool
    {
        $category = $this->getCategoryService->get(new GetCategoryRequest(
            userId: $request->getUserId(),
            categoryId: $request->getCategoryId(),
            canEdit: true
        ));

        return $this->categoryRepository->delete($category);
    }
}
