<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\UpdateCategoryRequest;
use App\Domain\Services\Models\Category\UpdateCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Put(
 *     path="/api/categories",
 *     @OA\RequestBody(
 *         description="Category object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/Category")
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Updates an category",
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
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="500", description="Repository (database) error"),
 *     @OA\Response(response="403", description="User should be the owner of the parent_category to create an sub-category"),
 *     @OA\Response(response="404", description="Category not found.")
 * )
 */
class UpdateCategoryAction extends Action
{

    /**
     * @Inject
     * @var UpdateCategoryService
     */
    private UpdateCategoryService $updateCategoryService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new UpdateCategoryRequest(
            userId: $this->user()->getId(),
            categoryId: (int)$this->resolveArg('id'),
            formData: $this->getFormData()
        );

        try {
            $category = $this->updateCategoryService->update($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($category);
    }
}