<?php

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\Exceptions\NoPermissionException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\User\GetUserRequest;
use App\Domain\Services\Models\User\GetUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpNotFoundException;

class ReadUserAction extends Action
{

    /**
     * @Inject
     * @var GetUserService
     */
    private GetUserService $getUserService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $request = new GetUserRequest(
            userId: (int)$this->resolveArg('id'),
            sessionUserId: $this->user()->getId()
        );

        try {
            $user = $this->getUserService->get($request);
        } catch (NoPermissionException) {
            throw new HttpForbiddenException($this->request);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData($user);
    }
}