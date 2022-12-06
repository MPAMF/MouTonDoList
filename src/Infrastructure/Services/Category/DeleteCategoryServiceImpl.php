<?php

namespace App\Infrastructure\Services\Category;

use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Category\Requests\DeleteCategoryRequest;
use App\Domain\Models\Category\Requests\GetCategoryRequest;
use App\Domain\Models\Category\Services\DeleteCategoryService;
use App\Domain\Models\Category\Services\GetCategoryService;
use DI\Annotation\Inject;

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