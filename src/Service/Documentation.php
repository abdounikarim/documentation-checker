<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class Documentation
{
    public function getContents()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');
        return $response->toArray();
    }
}