<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

abstract class CategoryAction extends Action
{

    /**
     * @Inject CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    protected UserCategoryRepository $userCategoryRepository;


    /**
     * @return array|object
     */
    protected function validate(): array|object
    {
        $data = $this->getFormData();

        $validator = $this->validator->validate($data, [
            'archived' => Validator::boolVal(),
            'position' => Validator::intType(), // limit
            'name' => Validator::notEmpty()->stringType()->length(min: 3, max: 63),
            'color' => Validator::notEmpty()->stringType()->length(max: 15),
            'parent_category_id' => Validator::oneOf(Validator::nullType(), Validator::intType())
        ]);

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        // Validator library is not up-to-date with intType: throwing deprecated error
        $data->position = intval($data->position);
        $subCategory = isset($data->parent_category_id);
        if ($subCategory) $data->parent_category_id = intval($data->parent_category_id);

        if ($data->position < 0 || $data->position > 1e6 || ($subCategory && $data->parent_category_id <= 0)) {
            throw new HttpBadRequestException($this->request, "Wrong position or parentCategoryId (should be positive)");
        }

        return $data;
    }

    /**
     * @param bool $checkCanEdit
     * @return Category
     */
    protected function getCategoryWithPermissionCheck(bool $checkCanEdit = true): Category
    {
        $categoryId = (int)$this->resolveArg('id');

        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (CategoryNotFoundException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }

        $parent = $category->getParentCategoryId() == null;

        // Check if user has permission to delete
        if ($category->getOwnerId() != $this->user()->getId()) {

            if ($parent) {
                throw new HttpForbiddenException($this->request);
            }

            if ($checkCanEdit) {
                if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId,
                    userId: $this->user()->getId(), accepted: true, canEdit: true)) {
                    throw new HttpForbiddenException($this->request);
                }
            } else {
                if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId,
                    userId: $this->user()->getId(), accepted: true)) {
                    throw new HttpForbiddenException($this->request);
                }
            }

        }

        return $category;
    }

}