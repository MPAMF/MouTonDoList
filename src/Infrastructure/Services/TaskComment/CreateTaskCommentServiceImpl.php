<?php

namespace App\Infrastructure\Services\TaskComment;

use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\TaskComment\CreateTaskCommentService;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use App\Infrastructure\Services\Service;

class CreateTaskCommentServiceImpl extends Service implements CreateTaskCommentService
{

    /**
     * @Inject
     * @var TaskCommentRepository
     */
    public TaskCommentRepository $taskCommentRepository;

    /**
     * @Inject
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * @Inject
     * @var UserCategoryCheckPermissionService
     */
    public UserCategoryCheckPermissionService $userCategoryCheckPermissionService;

    /**
     * {@inheritDoc}
     */
    public function create(CreateTaskCommentRequest $request): TaskComment
    {
        $taskComment = new TaskComment();

        $validator = $this->validator->validate($request->getFormData(), $taskComment->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $userId = $request->getUserId();
        //
        $taskComment->fromValidator($data);
        $taskComment->setAuthorId($userId);

        // Check category validity
        $taskComment->setTask($this->taskRepository->get($taskComment->getTaskId(), with: ['category']));

        // Check can edit
        if ($taskComment->getTask()->getCategory()->getOwnerId() != $userId) {
            $this->userCategoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
                userId: $userId,
                categoryId: $taskComment->getTask()->getCategoryId(),
            ));
        }

        if (!$this->taskCommentRepository->save($taskComment)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('TaskCommentCreateDBError'));
        }

        return $taskComment;
    }
}
