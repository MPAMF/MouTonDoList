<?php

namespace App\Application\Actions\Categories;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateCategoryAction extends CategoryAction
{

    /**
     * @Inject CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    private UserCategoryRepository $userCategoryRepository;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $categoryId = (int)$this->resolveArg('id');
        $data = $this->validate();

        try {
            $category = $this->categoryRepository->get($categoryId);
        } catch (CategoryNotFoundException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        }

        $parent = $category->getParentCategoryId() == null;

        // Check if user has permission to edit
        if ($category->getOwnerId() != $this->user()->getId()) {

            if ($parent) {
                throw new HttpForbiddenException($this->request);
            }

            if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId, userId: $this->user()->getId(), canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }

        }

        // replace values
        $category->setArchived($data->archived);
        $category->setColor($data->color);
        $category->setName($data->name);
        $category->setPosition($data->position);

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('CategoryUpdateDBError')], 500);
        }

        return $this->respondWithData($category, 200);
    }
}