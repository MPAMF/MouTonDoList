<?php

namespace App\Infrastructure\Twig;

use Slim\Flash\Messages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlashMessageExtension extends AbstractExtension
{
    private Messages $flash;

    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('flash', [$this, 'getMessages']),
        ];
    }

    public function getMessages(string $key = null): array|string
    {
        if ($key !== null) {
            $value = $this->flash->getMessage($key);
        } else {
            $value = $this->flash->getMessages();
        }

        return $value ?? [];
    }
}