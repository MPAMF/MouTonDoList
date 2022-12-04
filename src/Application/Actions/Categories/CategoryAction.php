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