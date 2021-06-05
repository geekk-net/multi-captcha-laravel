<?php

namespace Geekk\MultiCaptcha\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Geekk\MultiCaptcha\Laravel\CaptchaManager;
use Geekk\MultiCaptcha\ReCaptcha2\ReCaptcha2;
use Geekk\MultiCaptcha\HCaptcha\HCaptcha;
use Geekk\MultiCaptcha\KCaptcha\KCaptcha;
use Geekk\MultiCaptcha\Laravel\CaptchaStore;
use Geekk\MultiCaptcha\Laravel\HCaptchaRequest;
use Geekk\MultiCaptcha\Laravel\KCaptchaRequest;
use Geekk\MultiCaptcha\Laravel\ReCaptcha2Request;

/**
 *
 */
class CaptchaServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(CaptchaManager::class, function ($app) {
            return new CaptchaManager(config('captcha'), \App::$type);
        });
        $this->app->alias(CaptchaManager::class, 'multicaptcha.manager');
        $this->registerDrivers();
        $this->registerRequests();
    }

    private function registerDrivers()
    {
        $this->app->bind(ReCaptcha2::class, function ($app, $params) {
            return new ReCaptcha2($params['config']);
        });
        $this->app->alias(ReCaptcha2::class, 'multicaptcha.driver.recaptcha2');

        $this->app->bind(HCaptcha::class, function ($app, $params) {
            return new HCaptcha($params['config']);
        });
        $this->app->alias(HCaptcha::class, 'multicaptcha.driver.hcaptcha');

        $this->app->bind(KCaptcha::class, function ($app, $params) {
            $store = new CaptchaStore($app->make('cache')->store());
            return new KCaptcha($params['config'], $store);
        });
        $this->app->alias(KCaptcha::class, 'multicaptcha.driver.kcaptcha');
    }

    private function registerRequests() {
        $this->app->bind(ReCaptcha2Request::class, function ($app) {
            return ReCaptcha2Request::instanceByRequest($app->make(Request::class));
        });
        $this->app->alias(ReCaptcha2Request::class, 'multicaptcha.request.recaptcha2');

        $this->app->bind(HCaptchaRequest::class, function ($app) {
            return HCaptchaRequest::instanceByRequest($app->make(Request::class));
        });
        $this->app->alias(HCaptchaRequest::class, 'multicaptcha.request.hcaptcha');

        $this->app->bind(KCaptchaRequest::class, function ($app) {
            return KCaptchaRequest::instanceByRequest($app->make(Request::class));
        });
        $this->app->alias(KCaptchaRequest::class, 'multicaptcha.request.kcaptcha');
    }
}
