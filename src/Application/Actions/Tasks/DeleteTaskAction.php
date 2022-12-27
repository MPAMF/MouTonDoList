<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Requests\Task\DeleteTaskRequest;
use App\Domain\Services\Models\Task\DeleteTaskService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

class DeleteTaskAction extends Action
{

    /**
     * @Inject
     * @var DeleteTaskService
     */
    private DeleteTaskService $deleteTaskService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new DeleteTaskRequest(
            userId: $this->user()->getId(),
            taskId: (int)$this->resolveArg('id')
        );

        try {
            $this->deleteTaskService->delete($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (TaskNotFoundException|CategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(null, 204);
    }
}