<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class Documentation
{
    private function getContents()
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.github.com/repos/symfony/symfony-docs/contents');
        return $response->toArray();
    }

    public function getRstFiles()
    {
        $files = $this->getContents();
        foreach ($files as $file) {
            $length = strlen($file['name']);
            $extension = substr($file['name'], $length - 3);
            if($extension === 'rst') {
                dump($file);
            }
        }
    }
}