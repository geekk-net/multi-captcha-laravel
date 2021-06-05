<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\ReCaptcha2\ReCaptcha2Request as Base;
use Illuminate\Http\Request;

/**
 * ReCaptcha2Request for Laravel
 */
class ReCaptcha2Request extends Base
{

    public static function instanceByRequest(Request $request):self
    {
        return new static($request->post(self::RESPONSE_NAME), $request->ip());
    }

}
