<?php

namespace App\Services\TokenServices;

class TokenBase64Generator implements TokenGenerator
{

    public function create(string $publicUrlHostName, int $count, int $userId): ?string
    {
        if (empty($publicUrlHostName) || $count <= 0 || $userId <= 0) {
            return null;
        }
        $token = base64_encode($count . '+' . $userId . '+' . $publicUrlHostName);
        return substr($token, 0, 7);
    }
}