<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Category\CategoryNotFoundException;
use App\Domain\Category\CategoryRepository;
use App\Domain\UserCategory\UserCategoryRepository;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;

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