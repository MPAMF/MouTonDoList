<?php

namespace App\Infrastructure\Twig;

use Slim\Flash\Messages;
use Slim\Views\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlashMessageExtension extends AbstractExtension
{
    private Messages $flash;

    public function __construct(Messages $flash)
    {
        $this->flash = $flash;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('flash', [$this, 'getMessages']),
            new TwigFunction('hasFlash', [$this, 'hasFlash'])
        ];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasFlash(string $key) : bool
    {
        return $this->flash->hasMessage($key);
    }


    /**
     * @param string|null $key
     * @return array|string
     */
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