<?php

namespace App\Repositories\Contracts;

interface CartStorageInterface
{
    public function get(array $default = [], string|int|null $userId = null): array;
    public function put(array $value, string|int|null $userId = null): void;
    public function forget(string|int|null $userId = null): void;
}
