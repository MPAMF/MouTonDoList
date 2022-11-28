<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateCategoryAction extends Action
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
        $data = $this->getFormData();

        $validator = $this->validator->validate($data, [
            'archived' => Validator::boolVal(),
            'position' => Validator::intVal()->positive()->max(1e6), // limit
            'name' => Validator::stringType()->length(min: 3, max: 63),
            'color' => Validator::stringType()->length(max: 15),
            'parent_category_id' => Validator::oneOf(Validator::nullType(), Validator::intVal()->positive())
        ]);

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        // validate data ;

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

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
        }

        return $this->respondWithData($category, 200);
    }
}