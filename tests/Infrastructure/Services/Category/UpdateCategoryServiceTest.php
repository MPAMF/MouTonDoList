<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\UpdateCategoryRequest;
use App\Domain\Services\Models\Category\GetCategoryService;
use App\Domain\Services\Models\Category\UpdateCategoryService;
use App\Domain\Services\Models\Category\UpdateCategoryServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class UpdateCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private UpdateCategoryService $updateCategoryService;
    private TranslatorInterface $translator;
    private GetCategoryService $getCategoryService;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->updateCategoryService = new UpdateCategoryServiceImpl(new Validator(), $this->translator);
        $this->updateCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->updateCategoryService->categoryRepository = $this->categoryRepository;
        $this->getCategoryService = $this->createMock(GetCategoryService::class);
        $this->updateCategoryService->getCategoryService = $this->getCategoryService;
    }

    public function testUpdateCategory(): void
    {
        $this->userCategoryRepository->expects($this->once())
            ->method('save');

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
            ->method('save')->with(self::callback(function (Category $c) {
                $c->setId(1);
                return true;
            }))->willReturn(true);

        $this->getCategoryService->expects($this->once())->method('get')->willReturn(new Category());

        $updatedCategory = $this->updateCategoryService->update($request);

        // Ignore dates
        $updatedCategory->setCreatedAt($expected->getCreatedAt());
        $updatedCategory->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($updatedCategory, $expected);
    }
}