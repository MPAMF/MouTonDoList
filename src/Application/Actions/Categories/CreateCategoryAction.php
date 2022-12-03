<?php

namespace App\Application\Actions\Categories;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class CreateCategoryAction extends CategoryAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->validate();

        $userId = $this->user()->getId();
        //
        $category = new Category();
        $category->setArchived($data->archived);
        $category->setColor($data->color);
        $category->setName($data->name);
        $category->setPosition($data->position);
        $category->setParentCategoryId($data->parent_category_id);

        $parent = $category->getParentCategoryId() == null;

        if ($parent) {
            // owner id => parent category owner
            $category->setOwnerId($this->user()->getId());
        } else {

            // Parent category isn't none, check if user has permission to create a new subCategory
            if (!$this->userCategoryRepository->exists(null, categoryId: $category->getParentCategoryId(),
                userId: $userId, accepted: true, canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }

            // set subcategory owner to the owner of the parent category
            try {
                $parentCategory = $this->categoryRepository->get($category->getParentCategoryId());
            } catch (CategoryNotFoundException) {
                throw new HttpBadRequestException($this->request, $this->translator->trans('ParentCategoryNotFound'));
            }

            $category->setOwnerId($parentCategory->getOwnerId());

        }

        // TODO: Maybe check two same names?

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('CategoryCreateDBError')], 500);
        }

        if ($parent) {
            // Don't forget to create usercategory
            $userCategory = new UserCategory();
            $userCategory->setAccepted(true);
            $userCategory->setCanEdit(true);
            $userCategory->setCategoryId($category->getId());
            $userCategory->setUserId($userId);
            $this->userCategoryRepository->save($userCategory);
        }

        return $this->respondWithData($category);
    }
}