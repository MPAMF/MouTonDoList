<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\TaskComment\TaskCommentNotFoundException;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Requests\TaskComment\DeleteTaskCommentRequest;
use App\Domain\Services\Invitation\DeleteInvitationService;
use App\Domain\Services\TaskComment\DeleteTaskCommentService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

class DeleteInvitationAction extends Action
{

    /**
     * @Inject
     * @var DeleteInvitationService
     */
    private DeleteInvitationService $deleteInvitationService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new DeleteInvitationRequest(
            userId: $this->user()->getId(),
            invitationId: (int)$this->resolveArg('id')
        );

        try {
            $this->deleteInvitationService->delete($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (CategoryNotFoundException|UserCategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(null, 204);
    }
}