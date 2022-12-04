<?php

namespace App\Application\Actions\Tasks;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteTaskAction extends TaskAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $task = $this->getTaskWithPermissionCheck();
        // Useless to check if something was deleted
        $this->taskRepository->delete($task);

        return $this->respondWithData(null, 204);
    }
}