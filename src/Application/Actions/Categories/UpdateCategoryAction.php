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
        $data = $this->validate();
        $category = $this->getCategoryWithPermissionCheck();

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

        return $this->respondWithData($category);
    }
}