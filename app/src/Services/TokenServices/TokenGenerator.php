<?php

namespace App\Services\TokenServices;

interface TokenGenerator
{
    public function create(string $publicUrlHostName, int $count, int $userId): ?string;
}