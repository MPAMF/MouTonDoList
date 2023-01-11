<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\GetInvitationRequest;
use App\Domain\Services\Models\Invitation\GetInvitationService;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class ReadInvitationAction extends Action
{
    /**
     * @Inject
     * @var GetInvitationService
     */
    private GetInvitationService $getInvitationService;

    protected function action(): Response
    {
        $request = new GetInvitationRequest(
            userId: $this->user()->getId(),
            invitationId: (int)$this->resolveArg('id')
        );

        try {
            $invitation = $this->getInvitationService->get($request);
        } catch (NoPermissionException) {
            throw new HttpBadRequestException($this->request);
        } catch (CategoryNotFoundException|UserCategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($invitation);
    }
}
