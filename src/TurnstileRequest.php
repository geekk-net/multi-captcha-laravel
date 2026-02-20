<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\Turnstile\TurnstileRequest as Base;
use Illuminate\Http\Request;

/**
 * TurnstileRequest for Laravel
 */
class TurnstileRequest extends Base
{

    public static function instanceByRequest(Request $request): self
    {
        return new static(count($request->post()), $request->post(self::RESPONSE_NAME), $request->ip());
    }

}
