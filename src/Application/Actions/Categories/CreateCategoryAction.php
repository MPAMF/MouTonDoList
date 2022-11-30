<?php

namespace App\Application\Actions\Categories;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategory;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
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
        $category->setOwnerId($this->user()->getId());
        $category->setParentCategoryId($data->parent_category_id);

        $parent = $category->getParentCategoryId() == null;

        // Parent category isn't none, check if user has permission to create a new subCategory
        if (!$parent && !$this->userCategoryRepository->exists(null, categoryId: $category->getParentCategoryId(),
                userId: $userId, accepted: true, canEdit: true)) {
            throw new HttpForbiddenException($this->request);
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