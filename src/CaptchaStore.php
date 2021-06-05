<?php

namespace Geekk\MultiCaptcha\Laravel;

use Geekk\MultiCaptcha\CaptchaStoreInterface;
use Illuminate\Contracts\Cache\Repository;

/**
 * Store implementation for correct values of captcha
 */
class CaptchaStore implements CaptchaStoreInterface
{

    protected $store;
    protected $prefix;
    protected $seconds;

    public function __construct(Repository $store, $prefix = 'kcaptcha:', int $seconds = 5*60)
    {
        $this->store = $store;
        $this->prefix = $prefix;
        $this->seconds = $seconds;
    }

    protected function getStoreKey($key)
    {
        return "$this->prefix:{$key}";
    }

    public function getValue(?string $key = null): ?string
    {
        $value = $this->store->get($this->getStoreKey($key));
        $this->store->forget($this->getStoreKey($key));
        return $value;
    }

    public function setValue(string $value, ?string $key = null)
    {
        $this->store->put($this->getStoreKey($key), $value);
    }
}
