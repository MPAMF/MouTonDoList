<?php

namespace App\Application\Middleware;

use App\Application\Handlers\FlashMessageHandler;
use App\Application\Handlers\RedirectHandler;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Flash\Messages;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class Middleware implements MiddlewareInterface
{
    use RedirectHandler;
    use FlashMessageHandler;

    protected ResponseFactoryInterface $responseFactory;
    protected TranslatorInterface $translator;
    protected Messages $messages;

    public function __construct(ResponseFactoryInterface $responseFactory,
                                TranslatorInterface $translator,
                                Messages $messages)
    {
        $this->responseFactory = $responseFactory;
        $this->translator = $translator;
        $this->messages = $messages;
    }

}