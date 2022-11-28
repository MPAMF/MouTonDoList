<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;

class CreateCategoryAction extends Action
{

    /**
     * @Inject CategoryRepository
     */
    private CategoryRepository $categoryRepository;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        return $this->respondWithData();
    }
}