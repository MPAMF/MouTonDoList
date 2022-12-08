<?php

namespace App\Application\Actions\Categories;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Category\UpdateCategoryRequest;
use App\Domain\Services\Category\UpdateCategoryService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

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