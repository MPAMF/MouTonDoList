<?php

namespace App\Application\Actions\Auth\Login;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Models\User\UserNotFoundException;
use App\Domain\Requests\Auth\LoginRequest;
use App\Domain\Services\Auth\LoginService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends Action
{

    /**
     * @Inject
     * @var LoginService
     */
    private LoginService $loginService;

    protected function action(): Response
    {
        $request = new LoginRequest(
            email: $this->getFormData()['email'] ?? '',
            password: $this->getFormData()['password'] ?? ''
        );

        try {
            $this->loginService->login($request);
        } catch (BadRequestException) {
            return $this->respondWithView('home/content.twig', []);
        } catch (UserNotFoundException) {
            return $this->withError($this->translator->trans('AuthLoginFailed'))->redirect('account.login');
        }

        return $this->withSuccess($this->translator->trans('AuthLoginSuccess'))->redirect('dashboard');
    }
}
