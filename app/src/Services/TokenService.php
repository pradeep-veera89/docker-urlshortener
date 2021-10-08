<?php

namespace App\Services;

class TokenService
{
    public function create(string $publicUrlHostName, int $count, int $userId):?string
    {
        $token = base64_encode($count.'+'.$userId.'+'.$publicUrlHostName);
        return substr($token, 0,7);
    }
}

/*$token = new Token();
$publicUrl = 'google.com';
$count = 4;
$userId = 2;
$str = $token->create($publicUrl, $count, $userId);
echo $str;*/