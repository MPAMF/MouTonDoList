<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class DeleteCategoryAction extends Action
{

    /**
     * @Inject
     * @var CategoryRepository
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

            if (!$this->userCategoryRepository->exists(null, categoryId: $categoryId, userId: $this->user()->getId(), canEdit: true)) {
                throw new HttpForbiddenException($this->request);
            }

        }

        // Useless to check if something was deleted
        $this->categoryRepository->delete($category);

        return $this->respondWithData(null, 204);
    }
}