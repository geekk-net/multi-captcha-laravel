<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\KCaptcha\KCaptchaRequest as Base;
use Illuminate\Http\Request;

/**
 * KCaptchaRequest for Laravel
 */
class KCaptchaRequest extends Base
{

    public static function instanceByRequest(Request $request):self
    {
        return new static($request->post(self::RESPONSE_NAME), $request->post(self::KEY_NAME));
    }

}
