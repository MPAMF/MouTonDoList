<?php

namespace App\Domain\Services\Task;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryRepository;
use App\Domain\Models\Task\Task;
use App\Domain\Models\Task\TaskRepository;
use App\Domain\Models\UserCategory\UserCategoryRepository;
use App\Domain\Requests\Task\CreateTaskRequest;
use App\Domain\Requests\UserCategory\UserCategoryCheckPermissionRequest;
use App\Domain\Services\Service;
use App\Domain\Services\UserCategory\UserCategoryCheckPermissionService;
use DI\Annotation\Inject;

class CreateTaskServiceImpl extends Service implements CreateTaskService
{

    /**
     * @Inject
     * @var UserCategoryRepository
     */
    public UserCategoryRepository $userCategoryRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

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
    public function create(CreateTaskRequest $request): Task
    {
        $task = new Task();

        $validator = $this->validator->validate($request->getFormData(), $task->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        //
        $task->fromValidator($data);
        $task->setLastEditorId($request->getUserId());

        // Check category validity
        $task->setCategory($this->categoryRepository->get($task->getId()));

        // Only accept to create tasks in subcategories
        if ($task->getCategory()->getParentCategoryId() == null) {
            throw new NoPermissionException();
        }

        // Check can edit
        if ($task->getCategory()->getOwnerId() != $request->getUserId()) {
            $this->userCategoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
                userId: $request->getUserId(),
                categoryId: $task->getCategoryId(),
            ));
        }

        // Check assigned_id
        if ($task->getAssignedId() != null) {
            // Check if assigned user has access to the project
            if (!$this->userCategoryRepository->exists(null, $task->getCategoryId(), $task->getAssignedId(), accepted: true)) {
                throw new BadRequestException($this->translator->trans('AssignedUserNotFoundException'));
            }

            $this->userCategoryCheckPermissionService->exists(new UserCategoryCheckPermissionRequest(
                userId: $task->getAssignedId(),
                categoryId: $task->getCategoryId(),
                checkAccepted: false
            ));
        }

        if (!$this->taskRepository->save($task)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('TaskCreateDBError'));
        }

        return $task;
    }
}
