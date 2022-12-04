<?php

namespace App\Application\Actions\Tasks;

use Psr\Http\Message\ResponseInterface as Response;

class ReadTaskAction extends TaskAction
{

    protected function action(): Response
    {
        $task = $this->getTaskWithPermissionCheck(checkCanEdit: false);
        return $this->respondWithData($task);
    }
}