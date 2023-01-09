<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\UpdateCategoryRequest;
use App\Domain\Services\Category\UpdateCategoryService;
use App\Infrastructure\Services\Category\UpdateCategoryServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class UpdateCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private UpdateCategoryService $updateCategoryService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->updateCategoryService = new UpdateCategoryServiceImpl();
        $this->updateCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->updateCategoryService->categoryRepository = $this->categoryRepository;
    }

    public function testUpdateCategory(): void
    {
        $expected = new Category();
        $expected->setId(1);
        $expected->setOwnerId(1);
        $expected->setName('Test');
        $expected->setArchived(false);
        $expected->setColor('test');
        $expected->setPosition(0);
        $expected->setParentCategoryId(null);

        $data = [
            'owner_id' => 1,
            'parent_category_id' => NULL,
            'name' => 'Test',
            'color' => 'test',
            'position' => 0,
            'archived' => false,
        ];

        $request = new UpdateCategoryRequest(1, 1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('update')
            ->with(1, $data)
            ->willReturn($expected);

        $result = $this->updateCategoryService->update($request);

        $this->assertEquals($result, $expected);
    }
}