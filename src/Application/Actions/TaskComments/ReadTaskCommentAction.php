<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Services\Models\TaskComment\GetTaskCommentService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Get(
 *     path="/api/comments/{id}",
 *     description="Gets a comment",
 *     @OA\Response(
 *          response="200",
 *          description="Gets a comment",
 *          @OA\JsonContent(ref="#/components/schemas/TaskComment")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="TaskComment id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="404", description="Comment not found"),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="User should be the owner of the category or the invitation to get it.")
 * )
 */
class ReadTaskCommentAction extends Action
{
    /**
     * @Inject
     * @var GetTaskCommentService
     */
    private GetTaskCommentService $getTaskCommentService;

    protected function action(): Response
    {
        $request = new GetTaskCommentRequest(
            userId: $this->user()->getId(),
            taskCommentId: (int)$this->resolveArg('id'),
            canEdit: false
        );

        try {
            $task = $this->getTaskCommentService->get($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (TaskCommentNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($task);
    }
}