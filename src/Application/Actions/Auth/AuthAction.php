<?php

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\Auth\AuthInterface;
use App\Infrastructure\Repositories\UserRepository;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tagliatti\SlimValidation\ValidatorInterface;

abstract class AuthAction extends Action
{

    protected UserRepository $userRepository;
    protected AuthInterface $auth;

    public function __construct(
        LoggerInterface          $logger,
        Twig                     $twig,
        ResponseFactoryInterface $responseFactory,
        Messages                 $messages,
        TranslatorInterface      $translator,
        ValidatorInterface       $validator,
        UserRepository           $userRepository,
        AuthInterface            $auth
    )
    {
        parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
        $this->userRepository = $userRepository;
        $this->auth = $auth;
    }
}
