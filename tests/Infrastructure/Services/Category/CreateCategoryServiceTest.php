<?php

namespace Tests\Infrastructure\Services\Category;

use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\Category\CreateCategoryRequest;
use App\Domain\Services\Category\CreateCategoryService;
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
        class_alias(
            'Symfony\\Contracts\\Translation\\TranslatorInterface',
            'Symfony\\Component\\Translation\\TranslatorInterface'
        );
        $this->categoryRepository = $this->createMock(CategoryRepository::class);
        $this->userCategoryRepository = $this->createMock(UserCategoryRepository::class);
        $this->translator = $this->createMock(TranslatorInterface::class);
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