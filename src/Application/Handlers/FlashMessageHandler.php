<?php

namespace App\Application\Handlers;

trait FlashMessageHandler
{
    /**
     * @param string $key Flash message key
     * @param string $value Flash message text
     * @return $this Current Action instance
     */
    protected function withMessage(string $key, string $value) : static
    {
        $this->messages->addMessage($key, $value);
        return $this;
    }

    /**
     * @param string $value Error message
     * @return $this Current Action instance
     */
    protected function withError(string $value) : static
    {
        return $this->withMessage('errors', $value);
    }

    /**
     * @param string $value Success message
     * @return $this Current Action instance
     */
    protected function withSuccess(string $value) : static
    {
        return $this->withMessage('success', $value);
    }

    /**
     * @param string $value Info message
     * @return $this Current Action instance
     */
    protected function withInfo(string $value) : static
    {
        return $this->withMessage('infos', $value);
    }

}