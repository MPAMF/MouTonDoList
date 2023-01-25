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

/**
 * @OA\Put(
 *     path="/api/invitations",
 *     @OA\RequestBody(
 *         description="Invitation object",
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(ref="#/components/schemas/UserCategory")
 *         )
 *     ),
 *     @OA\Response(
 *          response="200",
 *          description="Creates an invitation",
 *          @OA\JsonContent(ref="#/components/schemas/UserCategory")
 *     ),
 *     @OA\Response(response="409", description="Invitation already exists"),
 *     @OA\Response(response="404", description="Given category or user not found"),
 *     @OA\Response(response="400", description="Given arguments not passed trough validator."),
 *     @OA\Response(response="500", description="Repository (database) error"),
 *     @OA\Response(response="403", description="User should be the owner of the category to create an invitation")
 * )
 */
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
