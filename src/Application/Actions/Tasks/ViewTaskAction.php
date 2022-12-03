<?php

namespace App\Application\Actions\Tasks;

use Psr\Http\Message\ResponseInterface as Response;

class ViewTaskAction extends TaskAction
{

    protected function action(): Response
    {
        $category = $this->getTaskWithPermissionCheck(checkCanEdit: false);
        return $this->respondWithData($category);
    }
}