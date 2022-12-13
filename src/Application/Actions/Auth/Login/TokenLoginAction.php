<?php

namespace App\Application\Actions\Auth\Login;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;
use App\Domain\Services\Auth\TokenLoginService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class TokenLoginAction extends Action
{

    /**
     * @Inject
     * @var TokenLoginService
     */
    private TokenLoginService $tokenLoginService;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $data = $this->getFormData();
        $request = new LoginRequest(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        try {
            $token = $this->tokenLoginService->login($request);
        } catch (BadRequestException $e) {
            throw new HttpBadRequestException($this->request, json_encode($e->getErrors()));
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }

        return $this->respondWithData(['token' => $token]);
    }
}