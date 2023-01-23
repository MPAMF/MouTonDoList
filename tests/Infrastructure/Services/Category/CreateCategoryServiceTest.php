<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\CreateCategoryRequest;
use App\Domain\Services\Models\Category\CreateCategoryService;
use App\Domain\Services\Models\Category\CreateCategoryServiceImpl;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use Illuminate\Contracts\Translation\Translator;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class CreateCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private CreateCategoryService $createCategoryService;
    private Translator $translator;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(Translator::class);
        $this->createCategoryService = new CreateCategoryServiceImpl(new Validator(), $this->translator);
        $this->createCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->createCategoryService->categoryRepository = $this->categoryRepository;
    }

    public function testCreateCategory(): void
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

        $request = new CreateCategoryRequest(1, $data);

        $this->categoryRepository->expects($this->once())
            ->method('save')->with(self::callback(function (Category $c) {
                $c->setId(1);
                return true;
            }))->willReturn(true);

        $createdCategory = $this->createCategoryService->create($request);

        // Ignore dates
        $createdCategory->setCreatedAt($expected->getCreatedAt());
        $createdCategory->setUpdatedAt($expected->getUpdatedAt());

        $this->assertEquals($createdCategory, $expected);
    }


}