<?php

namespace App\Domain\Services\Models\Category;

use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Domain\Requests\Category\UpdateCategoryRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\UserCategoryRepository;
use DI\Annotation\Inject;

class UpdateCategoryServiceImpl extends Service implements UpdateCategoryService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

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
    public function update(UpdateCategoryRequest $request): Category
    {
        $category = $this->getCategoryService->get(new GetCategoryRequest(
            userId: $request->getUserId(),
            categoryId: $request->getCategoryId(),
            canEdit: true
        ));
        $validator = $this->validator->validate($request->getFormData(), $category->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();

        // cannot change parent_category_id
        $data->parent_category_id = $category->getParentCategoryId();
        $category->fromValidator($data);

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('CategoryUpdateDBError'));
        }

        return $category;
    }
}
