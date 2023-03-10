<?php

namespace App\Domain\Services\Models\Task;

use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Task\Task;
use App\Domain\Requests\Task\GetTaskRequest;
use App\Domain\Requests\Task\UpdateTaskRequest;
use App\Domain\Services\Service;
use App\Infrastructure\Repositories\CategoryRepository;
use App\Infrastructure\Repositories\TaskRepository;

class UpdateTaskServiceImpl extends Service implements UpdateTaskService
{

    /**
     * @Inject
     * @var TaskRepository
     */
    public TaskRepository $taskRepository;

    /**
     * @Inject
     * @var CategoryRepository
     */
    public CategoryRepository $categoryRepository;

    /**
     * @Inject
     * @var GetTaskService
     */
    public GetTaskService $getTaskService;

    /**
     * {@inheritDoc}
     */
    public function update(UpdateTaskRequest $request): Task
    {
        $task = $this->getTaskService->get(new GetTaskRequest(
            userId: $request->getUserId(),
            taskId: $request->getTaskId(),
            canEdit: true
        ));

        $validator = $this->validator->validate($request->getFormData(), $task->getValidatorRules());

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }

        $data = $validator->getValues();
        $userId = $request->getUserId();

        // Check category validity
        if (!isset($data['category_id'])) {
            // categoryId == null is main category, cannot create tasks in those categories
            throw new BadRequestException($this->translator->trans('CategoryIdNotValid'));
        } else {
            // Check if current category has same parentCategory
            if (!$this->categoryRepository->exists($data['category_id'], $task->getCategory()->getParentCategoryId())) {
                throw new NoPermissionException();
            }
        }

        $oldPosition = $task->getPosition();
        $oldCategoryId = $task->getCategoryId();
        $task->fromValidator($data);
        $task->setLastEditorId($userId);

        if (!$this->taskRepository->save($task)) {
            // return with error?
            throw new RepositorySaveException($this->translator->trans('TaskUpdateDBError'));
        }

        // Category has changed, so reorder positions
        if ($task->getCategoryId() != $oldCategoryId) {
            $newCategoryId = $task->getCategoryId();
            $task->setCategoryId($oldCategoryId);
            $this->taskRepository->orderTasks($task, 0, $oldPosition, true);
            $task->setCategoryId($newCategoryId);
        }

        // drag & drop handling
        $this->taskRepository->orderTasks($task, $task->getPosition(),
            $task->getCategoryId() != $oldCategoryId ? -1 : $oldPosition, false);

        return $task;
    }
}
