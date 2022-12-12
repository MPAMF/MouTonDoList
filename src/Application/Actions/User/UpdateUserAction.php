<?php

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\UpdateUserRequest;
use App\Domain\Services\Models\User\UpdateUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class UpdateUserAction extends Action
{
    /**
     * @Inject
     * @var UpdateUserService
     */
    private UpdateUserService $updateUserService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new UpdateUserRequest(
            userId: (int)$this->resolveArg('id'),
            sessionUserId: $this->user()->getId(),
            formData: $this->getFormData(),
            method: $this->request->getMethod()
        );

        try {
            $user = $this->updateUserService->update($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($user);
    }
}