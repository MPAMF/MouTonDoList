<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Services\Models\Task\GetTaskService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Get(
 *     path="/api/tasks/{id}",
 *     description="Gets a task",
 *     @OA\Response(
 *          response="200",
 *          description="Gets a task",
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="Task id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="404", description="Task or category not found"),
 *     @OA\Response(response="403", description="User should be the owner of the category or the invitation to get it.")
 * )
 */
class ReadTaskAction extends Action
{

    /**
     * @Inject
     * @var GetTaskService
     */
    private GetTaskService $getTaskService;

    protected function action(): Response
    {
        $request = new GetTaskRequest(
            userId: $this->user()->getId(),
            taskId: (int)$this->resolveArg('id'),
            canEdit: false
        );

        try {
            $task = $this->getTaskService->get($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (TaskNotFoundException|CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($task);
    }
}