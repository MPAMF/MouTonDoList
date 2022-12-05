<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Category\Requests\CreateCategoryRequest;
use App\Domain\Models\Category\Services\CreateCategoryService;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Infrastructure\Services\Category\CreateCategoryServiceImpl;
use Symfony\Component\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\Validator;
use Tests\TestCase;

class CreateCategoryServiceTest extends TestCase
{
    private CategoryRepository $categoryRepository;
    private UserCategoryRepository $userCategoryRepository;
    private CreateCategoryService $createCategoryService;
    private TranslatorInterface $translator;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
        $this->createCategoryService = new CreateCategoryServiceImpl(new Validator(), $this->translator);
        $this->createCategoryService->userCategoryRepository = $this->userCategoryRepository;
        $this->createCategoryService->categoryRepository = $this->categoryRepository;
    }

    public function testCreateCategory(): void
    {
        $this->userCategoryRepository->expects($this->once())->method('save');

        $category = new Category();
        $category->setOwnerId(1);
        $category->setName('Test');
        $category->setArchived(false);
        $category->setColor('test');
        $category->setPosition(0);
        $category->setParentCategoryId(null);

        $rows = $category->toRow();
        unset($rows['id']);

        $request = new CreateCategoryRequest(1, $rows);

        $category->setId(1);

        $this->categoryRepository->expects($this->once())
            ->method('save')->willReturn(true);


        $createdCategory = $this->createCategoryService->create($request);

        $this->assertEquals($createdCategory, $category);
    }


}