<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\DeleteCategoryRequest;
use App\Domain\Services\Category\DeleteCategoryService;
use App\Infrastructure\Services\Category\DeleteCategoryServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class DeleteCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private DeleteCategoryService $deleteCategoryService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->deleteCategoryService = new DeleteCategoryServiceImpl();
        $this->deleteCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->deleteCategoryService->categoryRepository = $this->categoryRepository;
    }

    public function testDeleteCategory(): void
    {
        $this->categoryRepository->expects($this->once())
            ->method('delete')
            ->with(1)
            ->willReturn(true);

        $request = new DeleteCategoryRequest(1, 1);

        $result = $this->deleteCategoryService->delete($request);

        $this->assertTrue($result);
    }

}