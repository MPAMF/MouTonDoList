<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;
use App\Domain\Services\Models\TaskComment\DeleteTaskCommentService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Delete(
 *     path="/api/comments/{id}",
 *     description="Deletes a comment",
 *     @OA\Response(
 *          response="204",
 *          description="Deletes an comment"
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="Comment id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="404", description="Given comment not found"),
 *     @OA\Response(response="403", description="User has not the write permission of parent category.")
 * )
 */
class DeleteTaskCommentAction extends Action
{

    /**
     * @Inject
     * @var DeleteTaskCommentService
     */
    private DeleteTaskCommentService $deleteTaskCommentService;


    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new DeleteTaskCommentRequest(
            userId: $this->user()->getId(),
            taskCommentId: (int)$this->resolveArg('id')
        );

        try {
            $this->deleteTaskCommentService->delete($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (TaskCommentNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(null, 204);
    }
}