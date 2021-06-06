# multi-captcha-laravel

Laravel's integration for package geekk/multi-captcha-laravel

## Installation

Install package:

```
composer require geekk/multi-captcha-laravel
```

Create configuration file:

```
php artisan vendor:publish --provider="Geekk\MultiCaptcha\Laravel\CaptchaServiceProvider" --tag="config"
```

Fill driver's specific setting in it:

```php
'recaptcha2' => [
        'driver' => 'recaptcha2',
        'site_key' => 'your site key for reCaptcha v2',
        'secret_key' => 'your secret key for reCaptcha v2'
    ],
```

## Using

Get CaptchaManager from Laravel's dependency container:

```php
use Geekk\MultiCaptcha\Laravel\CaptchaManager;

$captchaManager = app(CaptchaManager::class)

$captcha = $captchaManager->getCaptcha();

// Render captcha in template
echo $captcha->render();

// Verify user's response
$result = $captcha->verify($captchaManager->getRequest($request));
```

## Customising captcha's view

Use css for a customizing.

For captcha's templates generated on frontend side you can get data from method `CaptchaInterface::getViewData()`.
