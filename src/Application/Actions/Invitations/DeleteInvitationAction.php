<?php

namespace App\Application\Actions\Invitations;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\Category\CategoryNotFoundException;
use App\Domain\Models\UserCategory\UserCategoryNotFoundException;
use App\Domain\Requests\Invitation\DeleteInvitationRequest;
use App\Domain\Services\Models\Invitation\DeleteInvitationService;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

/**
 * @OA\Delete(
 *     path="/api/invitations/{id}",
 *     description="Deletes an invitation",
 *     @OA\Response(
 *          response="204",
 *          description="Deletes an invitation"
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         description="Invitation id",
 *         in = "path",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(response="404", description="Given category or user not found"),
 *     @OA\Response(response="403", description="User should be the owner of the category or the invitation to delete it.")
 * )
 */
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