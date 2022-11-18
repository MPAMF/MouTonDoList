<?php

namespace App\Application\Actions\Auth;

use App\Application\Actions\Action;
use App\Domain\User\UserRepository;
use Awurth\SlimValidation\ValidatorInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages;
use Slim\Views\Twig;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AuthAction extends Action
{

    protected UserRepository $userRepository;

    public function __construct(
        LoggerInterface          $logger,
        Twig                     $twig,
        ResponseFactoryInterface $responseFactory,
        Messages                 $messages,
        TranslatorInterface      $translator,
        ValidatorInterface       $validator,
        UserRepository           $userRepository
    ) {
        parent::__construct($logger, $twig, $responseFactory, $messages, $translator, $validator);
        $this->userRepository = $userRepository;
    }
}
