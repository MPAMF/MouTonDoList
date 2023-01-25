<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Requests\Category\CreateCategoryRequest;
use App\Domain\Services\Models\Category\CreateCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;

/**
 * @OA\Post(
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
 *          description="Creates an category",
 *          @OA\JsonContent(ref="#/components/schemas/Category")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="500", description="Repository (database) error"),
 *     @OA\Response(response="403", description="User should be the owner of the parent_category to create an sub-category")
 * )
 */
class CreateCategoryAction extends Action
{

    /**
     * @Inject
     * @var CreateCategoryService
     */
    private CreateCategoryService $createCategoryService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new CreateCategoryRequest(
            userId: $this->user()->getId(),
            formData: $this->getFormData()
        );

        try {
            $category = $this->createCategoryService->create($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        }

        return $this->respondWithData($category);
    }
}