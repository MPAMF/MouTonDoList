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

/**
 * @OA\Patch(
 *     path="/api/users",
 *     @OA\RequestBody(
 *         description="User object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/User")
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="User id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Updates an User",
 *          @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="404", description="User was not found."),
 *     @OA\Response(response="403", description="This user already existe"),
 *     @OA\Response(response="500", description="Repository (database) error")
 * )
 */
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