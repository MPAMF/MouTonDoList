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

/**
 * @OA\Get(
 *     path="/api/invitations/{id}",
 *     description="Gets an invitation",
 *     @OA\Response(
 *          response="200",
 *          description="Gets an invitation",
 *          @OA\JsonContent(ref="#/components/schemas/Invitation")
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
 *     @OA\Response(response="403", description="User should be the owner of the category or the invitation to get it.")
 * )
 */
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
