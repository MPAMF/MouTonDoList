<?php
declare(strict_types=1);

namespace App\Application\Settings;

class Settings implements SettingsInterface
{
    private array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key = ''): mixed
    {
        return (empty($key)) ? $this->settings : $this->settings[$key];
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOrDefault(string $key, mixed $default): mixed
    {
        $result =$this->settings[$key];
        return $result ?? $default;
    }
}
