<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\HCaptcha\HCaptchaRequest as Base;
use Illuminate\Http\Request;

/**
 * HCaptchaRequest for Laravel
 */
class HCaptchaRequest extends Base
{

    public static function instanceByRequest(Request $request):self
    {
        return new static(count($request->post()), $request->post(self::RESPONSE_NAME), $request->ip());
    }

}
