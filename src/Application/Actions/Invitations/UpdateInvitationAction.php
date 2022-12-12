<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\UpdateInvitationRequest;
use App\Domain\Services\Models\Invitation\UpdateInvitationService;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;

class UpdateInvitationAction extends Action
{

    /**
     * @Inject
     * @var UpdateInvitationService
     */
    private UpdateInvitationService $updateInvitationService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        $request = new UpdateInvitationRequest(
            userId: $this->user()->getId(),
            invitationId: (int)$this->resolveArg('id'),
            formData: $this->getFormData()
        );

        try {
            $invitation = $this->updateInvitationService->update($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (CategoryNotFoundException|UserCategoryNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($invitation);
    }
}
