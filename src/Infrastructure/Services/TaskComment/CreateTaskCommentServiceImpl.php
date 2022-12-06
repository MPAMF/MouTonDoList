<?php

namespace App\Infrastructure\Services\TaskComment;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskNotFoundException;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\TaskComment\TaskComment;
use App\Domain\Models\TaskComment\TaskCommentRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Requests\TaskComment\CreateTaskCommentRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Task\CreateTaskService;
use App\Domain\Services\TaskComment\CreateTaskCommentService;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use App\Infrastructure\Services\Service;
use DI\Annotation\Inject;

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