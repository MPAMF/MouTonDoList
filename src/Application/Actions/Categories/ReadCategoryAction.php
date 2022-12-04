<?php

namespace App\Application\Actions\Categories;

use Psr\Http\Message\ResponseInterface as Response;

class ReadCategoryAction extends CategoryAction
{

    protected function action(): Response
    {
        $category = $this->getCategoryWithPermissionCheck(checkCanEdit: false);
        return $this->respondWithData($category);
    }
}