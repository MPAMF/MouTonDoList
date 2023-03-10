<?php

namespace App\Application\Actions\TaskComments;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;
use App\Domain\Services\Models\TaskComment\CreateTaskCommentService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;

/**
 * @OA\Post(
 *     path="/api/comments",
 *     @OA\RequestBody(
 *         description="TaskComment object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/TaskComment")
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Creates an task comment",
 *          @OA\JsonContent(ref="#/components/schemas/TaskComment")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="User should have the write permission on the parent category"),
 *     @OA\Response(response="500", description="Repository (database) error")
 * )
 */
class CreateTaskCommentAction extends Action
{
    /**
     * @Inject
     * @var CreateTaskCommentService
     */
    private CreateTaskCommentService $createTaskCommentService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new CreateTaskCommentRequest(
            userId: $this->user()->getId(),
            formData: $this->getFormData()
        );

        try {
            $taskComment = $this->createTaskCommentService->create($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        }

        return $this->respondWithData($taskComment);
    }
}