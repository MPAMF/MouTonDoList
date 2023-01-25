<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\UpdateTaskRequest;
use App\Domain\Services\Models\Task\UpdateTaskService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Put(
 *     path="/api/tasks",
 *     @OA\RequestBody(
 *         description="Task object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/Task")
 *         )
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
 *     @OA\Response(
 *          response="200",
 *          description="Updates a task",
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="User should have the write permission on the parent category"),
 *     @OA\Response(response="404", description="Task or ategory not found"),
 *     @OA\Response(response="500", description="Repository (database) error")
 * )
 */
class UpdateTaskAction extends Action
{

    /**
     * @Inject
     * @var UpdateTaskService
     */
    private UpdateTaskService $updateTaskService;


    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new UpdateTaskRequest(
            userId: $this->user()->getId(),
            taskId: (int)$this->resolveArg('id'),
            formData: $this->getFormData()
        );

        try {
            $task = $this->updateTaskService->update($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (CategoryNotFoundException|TaskNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($task);
    }
}