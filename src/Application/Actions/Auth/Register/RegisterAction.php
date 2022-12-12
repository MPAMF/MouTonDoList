<?php

namespace App\Application\Actions\Auth\Register;

use App\Application\Actions\Auth\AuthAction;
use App\Domain\Exceptions\BadRequestException;
use App\Domain\Exceptions\RepositorySaveException;
use App\Domain\Requests\Auth\RegisterUserRequest;
use App\Domain\Services\Auth\RegisterUserService;
use DI\Annotation\Inject;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends AuthAction
{

    /**
     * @Inject
     * @var RegisterUserService
     */
    private RegisterUserService $registerUserService;

    protected function action(): Response
    {
        try {
            $this->registerUserService->register(new RegisterUserRequest($this->getFormData()));
        } catch (BadRequestException|RepositorySaveException $e) {
            return $this->withError($e->getMessage())->respondWithView('home/content.twig', []);
        }

        return $this->withSuccess($this->translator->trans('AuthRegisterSuccess'))->redirect('account.login');
    }
}