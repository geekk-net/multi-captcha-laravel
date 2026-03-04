<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\Gregwar\GregwarRequest as Base;
use Illuminate\Http\Request;

/**
 * GregwarRequest for Laravel.
 */
class GregwarRequest extends Base
{
    public static function instanceByRequest(Request $request): self
    {
        return new static(
            count($request->post()),
            $request->post(self::RESPONSE_NAME),
            $request->post(self::KEY_NAME)
        );
    }
}

