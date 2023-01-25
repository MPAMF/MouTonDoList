<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\TaskComment\UpdateTaskCommentRequest;
use App\Domain\Services\Models\TaskComment\UpdateTaskCommentService;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Put(
 *     path="/api/comments",
 *     @OA\RequestBody(
 *         description="TaskComment object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/TaskComment")
 *         )
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
 *     @OA\Response(
 *          response="200",
 *          description="Updates an task comment",
 *          @OA\JsonContent(ref="#/components/schemas/TaskComment")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="User should have the write permission on the parent category"),
 *     @OA\Response(response="404", description="Comment could not be found"),
 *     @OA\Response(response="500", description="Repository (database) error")
 * )
 */
class UpdateTaskCommentAction extends Action
{

    /**
     * @Inject
     * @var UpdateTaskCommentService
     */
    private UpdateTaskCommentService $updateTaskCommentService;


    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new UpdateTaskCommentRequest(
            userId: $this->user()->getId(),
            taskCommentId: (int)$this->resolveArg('id'),
            formData: $this->getFormData()
        );

        try {
            $taskComment = $this->updateTaskCommentService->update($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (TaskCommentNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($taskComment);
    }
}