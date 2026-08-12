<?php

namespace App\Repositories\Cache;

use App\Repositories\Contracts\CartStorageInterface;
use Illuminate\Support\Facades\Session;

class SessionCartStorage implements CartStorageInterface
{
    public function get(string $key, array $default = []): array
    {
        return Session::get($key, $default);
    }

    public function put(string $key, array $value): void
    {
        Session::put($key, $value);
    }

    public function forget(string $key): void
    {
        Session::forget($key);
    }
}
