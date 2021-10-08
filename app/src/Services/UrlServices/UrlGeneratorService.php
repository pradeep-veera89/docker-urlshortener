<?php

namespace App\Services\UrlServices;

class UrlGeneratorService
{

    public function build(string $hostName, string $token, bool $ssl=false):?string
    {
        $hostName = "localhost";
        //$hostName = $_ENV['HOSTNAME']?? '';
        if(empty($token) || empty($hostName) ) {
            return '';
        }
        $scheme = $ssl ? 'https': 'http';
        $url = $scheme . '://'.$hostName.'/'.$token;
        return $this->sanitize($url);
    }

    private function sanitize(string $url):?string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }
}