<?php

/**
 * geekk/multi-captcha-laravel configuration file
 */
return [

    // Default connection
    'default' => 'recaptcha2',

    'connections' => [

        'recaptcha2' => [
            'driver' => 'recaptcha2',
            'site_key' => 'your site key',
            'secret_key' => 'your secret key'
        ],

        'hcaptcha' => [
            'driver' => 'hcaptcha',
            'site_key' => 'your site key',
            'secret_key' => 'your secret key'
        ],

        'kcaptcha' => [
            'driver' => 'kcaptcha',
            'show_credits' => false
        ],

        'gregwar' => [
            'driver' => 'gregwar',
            // optional: width, height, length, quality, allowed_symbols
        ],

        'turnstile' => [
            'driver' => 'turnstile',
            'site_key' => 'your site key',
            'secret_key' => 'your secret key'
        ]

    ]
];
