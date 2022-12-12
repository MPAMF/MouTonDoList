<?php

namespace App\Domain\Services\TaskComment;

use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Requests\TaskComment\GetTaskCommentRequest;
use App\Domain\Requests\TaskComment\UpdateTaskCommentRequest;
use App\Domain\Services\Service;
use DI\Annotation\Inject;

class UpdateTaskCommentServiceImpl extends Service implements UpdateTaskCommentService
{

    /**
     * @Inject
     * @var TaskCommentRepository
     */
    public TaskCommentRepository $taskCommentRepository;

    /**
     * @Inject
     * @var GetTaskCommentService
     */
    public GetTaskCommentService $getTaskCommentService;

    /**
     * {@inheritDoc}
     */
    public function update(UpdateTaskCommentRequest $request): TaskComment
    {
        $taskComment = $this->getTaskCommentService->get(new GetTaskCommentRequest(
            userId: $request->getUserId(),
            taskCommentId: $request->getTaskCommentId(),
            canEdit: true
        ));

        $validator = $this->validator->validate($request->getFormData(), $taskComment->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $userId = $request->getUserId();

        if ($taskComment->getAuthorId() != $userId) {
            throw new NoPermissionException();
        }

        // Disable update of author_id and task_id
        $data->author_id = $taskComment->getAuthorId();
        $data->task_id = $taskComment->getTaskId();
        //
        $taskComment->fromValidator($data);

        // Useless to check if something was deleted
        if (!$this->taskCommentRepository->save($taskComment)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('TaskUpdateDBError'));
        }

        return $taskComment;
    }
}
