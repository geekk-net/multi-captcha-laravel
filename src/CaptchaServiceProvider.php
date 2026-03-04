<?php

namespace Geekk\MultiCaptcha\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Geekk\MultiCaptcha\HCaptcha\HCaptcha;
use Geekk\MultiCaptcha\KCaptcha\KCaptcha;
use Geekk\MultiCaptcha\Gregwar\Gregwar;
use Geekk\MultiCaptcha\ReCaptcha2\ReCaptcha2;
use Geekk\MultiCaptcha\Turnstile\Turnstile;

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
            return new CaptchaManager(config('captcha'));
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

        $this->app->bind(Gregwar::class, function ($app, $params) {
            $store = new CaptchaStore($app->make('cache')->store());
            return new Gregwar($params['config'], $store);
        });
        $this->app->alias(Gregwar::class, 'multicaptcha.driver.gregwar');

        $this->app->bind(Turnstile::class, function ($app, $params) {
            return new Turnstile($params['config']);
        });
        $this->app->alias(Turnstile::class, 'multicaptcha.driver.turnstile');
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

        $this->app->bind(TurnstileRequest::class, function ($app) {
            return TurnstileRequest::instanceByRequest($app->make(Request::class));
        });
        $this->app->alias(TurnstileRequest::class, 'multicaptcha.request.turnstile');

        $this->app->bind(GregwarRequest::class, function ($app) {
            return GregwarRequest::instanceByRequest($app->make(Request::class));
        });
        $this->app->alias(GregwarRequest::class, 'multicaptcha.request.gregwar');
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
            'multicaptcha.driver.recaptcha2',
            HCaptcha::class,
            'multicaptcha.driver.hcaptcha',
            KCaptcha::class,
            'multicaptcha.driver.kcaptcha',
            Gregwar::class,
            'multicaptcha.driver.gregwar',
            Turnstile::class,
            'multicaptcha.driver.turnstile',
            ReCaptcha2Request::class,
            'multicaptcha.request.recaptcha2',
            HCaptchaRequest::class,
            'multicaptcha.request.hcaptcha',
            KCaptchaRequest::class,
            'multicaptcha.request.kcaptcha',
            GregwarRequest::class,
            'multicaptcha.request.gregwar',
            TurnstileRequest::class,
            'multicaptcha.request.turnstile',
        ];
    }
}
