<?php

namespace App\Application\Actions\Tasks;

use App\Application\Actions\Action;
use App\Domain\Requests\Invitation\ListInvitationRequest;
use App\Domain\Requests\Task\SearchTaskRequest;
use App\Domain\Services\Models\Invitation\ListInvitationService;
use App\Domain\Services\Models\Task\SearchTaskService;
use Psr\Http\Message\ResponseInterface as Response;

class SearchTaskAction extends Action
{

    /**
     * @Inject
     * @var SearchTaskService
     */
    private SearchTaskService $searchTaskService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        $data = $this->searchTaskService->search(new SearchTaskRequest(
            userId: $this->user()->getId(),
            searchInput: $this->resolveArg('input')
        ));

        return $this->respondWithData($data);
    }
}