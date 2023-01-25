<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Services\Models\Task\CreateTaskService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Post(
 *     path="/api/tasks",
 *     @OA\RequestBody(
 *         description="Task object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/Task")
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Creates an task",
 *          @OA\JsonContent(ref="#/components/schemas/Task")
 *     ),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="403", description="User should have the write permission on the parent category")
 *     @OA\Response(response="404", description="Given category not found")
 *     @OA\Response(response="500", description="Repository (database) error"),
 * )
 */
class CreateTaskAction extends Action
{

    /**
     * @Inject
     * @var CreateTaskService
     */
    public CreateTaskService $createTaskService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new CreateTaskRequest(
            userId: $this->user()->getId(),
            formData: $this->getFormData()
        );

        try {
            $task = $this->createTaskService->create($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, $e->getMessage());
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($task);
    }
}