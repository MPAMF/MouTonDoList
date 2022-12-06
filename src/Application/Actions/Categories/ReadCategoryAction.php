<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\Requests\GetCategoryRequest;
use App\Domain\Models\Category\Services\GetCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

class ReadCategoryAction extends Action
{

    /**
     * @Inject
     * @var GetCategoryService
     */
    private GetCategoryService $getCategoryService;

    protected function action(): Response
    {
        $request = new GetCategoryRequest(
            userId: $this->user()->getId(),
            categoryId: (int)$this->resolveArg('id'),
            canEdit: false
        );

        try {
            $category = $this->getCategoryService->get($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($category);
    }
}