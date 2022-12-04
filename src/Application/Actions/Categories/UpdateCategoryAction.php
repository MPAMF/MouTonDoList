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
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $category = $this->getCategoryWithPermissionCheck();

        $validator = $this->validator->validate($data, $category->getValidatorRules());

        if (!$validator->isValid()) {
            throw new HttpBadRequestException($this->request, json_encode($validator->getErrors()));
        }

        $data = $validator->getValues();

        // cannot change parent_category_id
        $data->parent_category_id = $category->getParentCategoryId();

        $category->fromValidator($data);

        // Useless to check if something was deleted
        if (!$this->categoryRepository->save($category)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('CategoryUpdateDBError')], 500);
        }

        return $this->respondWithData($category);
    }
}