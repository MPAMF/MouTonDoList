<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class ViewCategoryAction extends CategoryAction
{

    protected function action(): Response
    {
        $category = $this->getCategoryWithPermissionCheck(checkCanEdit: false);
        return $this->respondWithData($category);
    }
}