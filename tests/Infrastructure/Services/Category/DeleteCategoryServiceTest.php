<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategory;
use App\Domain\Requests\Category\DeleteCategoryRequest;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Domain\Services\Models\Category\DeleteCategoryService;
use App\Domain\Services\Models\Category\DeleteCategoryServiceImpl;
use App\Domain\Services\Models\Category\GetCategoryService;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use PHPUnit\Framework\TestCase;

class DeleteCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private DeleteCategoryService $deleteCategoryService;
    private GetCategoryService $getCategoryService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->deleteCategoryService = new DeleteCategoryServiceImpl();
        $this->deleteCategoryService->categoryRepository = $this->categoryRepository;
        $this->getCategoryService = $this->createMock(GetCategoryService::class);
        $this->deleteCategoryService->getCategoryService = $this->getCategoryService;
    }

    public function testDeleteCategory(): void
    {
        $category = new Category();
        $category->setId(1);
        $category->setOwnerId(1);
        $category->setName('Test');
        $category->setArchived(false);
        $category->setColor('test');
        $category->setPosition(0);
        $category->setParentCategoryId(null);

        $getCategoryRequest = new GetCategoryRequest(
            userId: 1,
            categoryId: 1,
            canEdit: true,
        );

        $this->getCategoryService->expects($this->once())
            ->method('get')
            ->with($getCategoryRequest)
            ->willReturn($category);

        $this->categoryRepository->expects($this->once())
            ->method('delete')
            ->with($category)
            ->willReturn(1);

        $deleteCategoryRequest = new DeleteCategoryRequest(
            userId: 1,
            categoryId: 1
        );

        $result = $this->deleteCategoryService->delete($deleteCategoryRequest);

        $this->assertTrue($result);
    }
}