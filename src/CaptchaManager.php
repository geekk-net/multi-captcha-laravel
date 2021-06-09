<?php

namespace Geekk\MultiCaptcha\Laravel;

use Illuminate\Http\Request;
use Geekk\MultiCaptcha\CaptchaInterface;
use Geekk\MultiCaptcha\CaptchaRequestInterface;


/**
 *
 */
class CaptchaManager
{

    protected $config;

    protected $connectionName;

    protected $connectionConfig;

    public function __construct(array $config, ?string $connection = null)
    {
        $this->config = $config;
        $this->setConnection($connection);
    }

    public function setConnection(?string $connection)
    {
        $this->connectionName = $connection ?? $this->config['default'];
    }

    private function loadDriverConfig()
    {
        $this->connectionConfig = $this->config['connections'][$this->connectionName];
    }

    public function getCaptcha(): CaptchaInterface
    {
        $this->loadDriverConfig();
        $driverName = $this->connectionConfig['driver'];
        return app()->makeWith("multicaptcha.driver.{$driverName}", [ 'config' => $this->connectionConfig ]);
    }

    public function getRequest(Request $request): CaptchaRequestInterface
    {
        $driverName = $this->connectionConfig['driver'];
        return app("multicaptcha.request.{$driverName}");
    }
}
