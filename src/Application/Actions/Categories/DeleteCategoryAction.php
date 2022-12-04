<?php

namespace App\Application\Actions\Categories;

use Psr\Http\Message\ResponseInterface as Response;

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