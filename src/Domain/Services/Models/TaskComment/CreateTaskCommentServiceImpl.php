<?php

namespace App\Domain\Services\Models\TaskComment;

use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Models\UserCategory\UserCategoryCheckPermissionService;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\TaskCommentRepository;
use App\Infrastructure\Repositories\TaskRepository;

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
