<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\GetCategoryRequest;
use App\Domain\Services\Models\Category\GetCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Get(
 *     path="/api/categories/{id}",
 *     description="Gets an category",
 *     @OA\Response(
 *          response="200",
 *          description="Gets an category",
 *          @OA\JsonContent(ref="#/components/schemas/Category")
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
 *     @OA\Response(response="403", description="User should be the owner or has read permissions on the parent category to get it.")
 * )
 */
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