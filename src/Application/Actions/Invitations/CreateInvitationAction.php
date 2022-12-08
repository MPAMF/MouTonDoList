<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\AlreadyExistsException;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Invitation\CreateInvitationRequest;
use App\Domain\Services\Invitation\CreateInvitationService;
use App\Domain\Services\Invitation\ListInvitationService;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;

class CreateInvitationAction extends Action
{

    /**
     * @Inject
     * @var CreateInvitationService
     */
    private CreateInvitationService $createInvitationService;

    /**
     * {@inheritDoc}
     */
    protected function action(): Response
    {
        $request = new CreateInvitationRequest(
            userId: $this->user()->getId(),
            formData: $this->getFormData()
        );

        try {
            $invitation = $this->createInvitationService->create($request);
        } catch (AlreadyExistsException $e) {
            throw new HttpException($this->request, $e->getMessage(), 409);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (RepositorySaveException $e) {
            throw new HttpInternalServerErrorException($this->request, $e->getMessage());
        } catch (ValidationException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (CategoryNotFoundException|UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($invitation);
    }

}
