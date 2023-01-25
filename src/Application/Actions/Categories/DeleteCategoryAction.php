<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\DeleteCategoryRequest;
use App\Domain\Services\Models\Category\DeleteCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Delete(
 *     path="/api/categories/{id}",
 *     description="Deletes a category",
 *     @OA\Response(
 *          response="204",
 *          description="Category successfully deleted"
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="Category id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="404", description="Given category not found"),
 *     @OA\Response(response="403", description="User has not the write permission of parent category.")
 * )
 */
class DeleteCategoryAction extends Action
{

    /**
     * @Inject
     * @var DeleteCategoryService
     */
    private DeleteCategoryService $deleteCategoryService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new DeleteCategoryRequest(
            userId: $this->user()->getId(),
            categoryId: (int)$this->resolveArg('id')
        );

        try {
            $this->deleteCategoryService->delete($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(null, 204);
    }
}