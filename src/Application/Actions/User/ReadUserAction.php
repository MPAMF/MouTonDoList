<?php

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\GetUserRequest;
use App\Domain\Services\Models\User\GetUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     description="Gets a user",
 *     @OA\Response(
 *          response="200",
 *          description="Gets a user",
 *          @OA\JsonContent(ref="#/components/schemas/User")
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
 *     @OA\Response(response="404", description="User not found"),
 *     @OA\Response(response="403", description="Permission denied (forbidden)")
 * )
 */
class ReadUserAction extends Action
{

    /**
     * @Inject
     * @var GetUserService
     */
    private GetUserService $getUserService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new GetUserRequest(
            userId: (int)$this->resolveArg('id'),
            sessionUserId: $this->user()->getId()
        );

        try {
            $user = $this->getUserService->get($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($user);
    }
}