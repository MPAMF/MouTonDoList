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

class DeleteCategoryAction extends CategoryAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $category = $this->getCategoryWithPermissionCheck();
        // Useless to check if something was deleted
        $this->categoryRepository->delete($category);

        return $this->respondWithData(null, 204);
    }
}