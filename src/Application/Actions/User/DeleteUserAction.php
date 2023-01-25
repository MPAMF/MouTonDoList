<?php

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Category\DeleteCategoryRequest;
use App\Domain\Requests\User\DeleteUserRequest;
use App\Domain\Services\Models\User\DeleteUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     description="Deletes an user",
 *     @OA\Response(
 *          response="204",
 *          description="Deletes an user"
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
 *     @OA\Response(response="404", description="Given user not found"),
 *     @OA\Response(response="403", description="Permission denied (forbidden)")
 * )
 */
class DeleteUserAction extends Action
{

    /**
     * @Inject
     * @var DeleteUserService
     */
    private DeleteUserService $deleteUserService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new DeleteUserRequest(
            userId: (int)$this->resolveArg('id'),
            sessionUserId: $this->user()->getId()
        );

        try {
            $this->deleteUserService->delete($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(null, 204);
    }
}