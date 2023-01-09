<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Domain\Services\Category\GetCategoryService;
use App\Infrastructure\Services\Category\GetCategoryServiceImpl;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use Tests\TestCase;

class GetCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private GetCategoryService $getCategoryService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->getCategoryService = new GetCategoryServiceImpl();
        $this->getCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->getCategoryService->categoryRepository = $this->categoryRepository;
    }

    public function testGetCategory(): void
    {
        $expected = new Category();
        $expected->setId(1);
        $expected->setOwnerId(1);
        $expected->setName('Test');
        $expected->setArchived(false);
        $expected->setColor('test');
        $expected->setPosition(0);
        $expected->setParentCategoryId(null);

        $this->categoryRepository->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($expected);

        $request = new GetCategoryRequest(1, 1);

        $result = $this->getCategoryService->get($request);

        $this->assertEquals($result, $expected);
    }
}
