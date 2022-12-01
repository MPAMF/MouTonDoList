<?php

namespace App\Application\Actions\Tasks;

use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

class UpdateTaskAction extends TaskAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->validate();
        $task = $this->getTaskWithPermissionCheck();

        // replace values
        $task->setName($data->name);
        $task->setDescription($data->description);
        $task->setDueDate($data->due_date);
        $task->setChecked($data->checked);
        $task->setPosition($data->position);
        $task->setLastEditorId($data->last_editor_id ?? null);
        $task->setAssignedId($data->parent_category_id ?? null);

        // Useless to check if something was deleted
        if (!$this->taskRepository->save($task)) {
            // return with error?
            return $this->respondWithData(['error' => $this->translator->trans('TaskUpdateDBError')], 500);
        }

        return $this->respondWithData($task);
    }
}