<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Action;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Requests\Auth\RegisterRequest;
use App\Domain\Services\Auth\RegisterUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends Action
{

    /**
     * @Inject
     * @var RegisterUserService
     */
    private RegisterUserService $registerUserService;

    protected function action(): Response
    {
        $data = $this->getFormData();
        $request = new RegisterRequest(
            email: $data['email'] ?? '',
            username: $data['username'] ?? '',
            password: $data['password'] ?? '',
            passwordConf: $data['password-conf'] ?? ''
        );

        try {
            $this->registerUserService->register($request);
        } catch (BadRequestException|RepositorySaveException $e) {
            return $this->withError($e->getMessage())->respondWithView('home/content.twig', []);
        }

        return $this->withSuccess($this->translator->trans('AuthRegisterSuccess'))->redirect('account.login');
    }
}