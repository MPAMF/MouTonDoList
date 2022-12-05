<?php

namespace App\Application\Actions\Categories;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\Category;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Category\Requests\CreateCategoryRequest;
use App\Domain\Models\Category\Services\CreateCategoryService;
use App\Domain\Models\UserCategory\UserCategory;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Exceptions\ValidatorException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class CreateCategoryAction extends CategoryAction
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
        $userId = $this->user()->getId();
        $data = $this->getFormData();

        try {
            $category = $this->createCategoryService->create(new CreateCategoryRequest($userId, $data));
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            return $this->respondWithData(['error' => $e->getMessage()], 500);
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        }

        return $this->respondWithData($category);
    }
}