<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Services\Task\GetTaskService;
use App\Domain\Services\TaskComment\GetTaskCommentService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

class ReadInvitationAction extends Action
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