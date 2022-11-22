<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryRepository;
use Psr\Http\Message\ResponseInterface as Response;

class CreateCategoryAction extends Action
{

    /**
     * @Inject CategoryRepository
     */
    private CategoryRepositor $categoryRepository;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        // TODO: Implement action() method.
    }
}