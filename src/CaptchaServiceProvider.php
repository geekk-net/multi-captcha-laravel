<?php

namespace Geekk\MultiCaptcha\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Geekk\MultiCaptcha\ReCaptcha2\ReCaptcha2;
use Geekk\MultiCaptcha\HCaptcha\HCaptcha;
use Geekk\MultiCaptcha\KCaptcha\KCaptcha;

/**
 *
 */
class CaptchaServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/captcha.php' => config_path('captcha.php')
        ], 'config');
    }

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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            CaptchaManager::class,
            ReCaptcha2::class,
            HCaptcha::class,
            KCaptcha::class,
            ReCaptcha2Request::class,
            HCaptchaRequest::class,
            KCaptchaRequest::class
        ];
    }
}
