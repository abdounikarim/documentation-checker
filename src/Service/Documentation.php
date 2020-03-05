<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;

class Documentation
{
    private $connection;
    /**
     * @var ContainerBagInterface
     */
    private $containerBag;

    public function __construct(ContainerBagInterface $containerBag)
    {
        $this->containerBag = $containerBag;
    }

    protected function checkConnection()
    {
        if($this->connection) {
            return $this->connection;
        }
        return $this->connect();
    }

    private function connect()
    {
        $this->connection = HttpClient::create();
        $this->connection = new ScopingHttpClient($this->connection, [
            'https://api\.github\.com/' => [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => 'token '.$this->containerBag->get('github_token'),
                ],
            ]
        ]);
        return $this->connection;
    }

    private function getContents()
    {
        $response = $this->checkConnection()->request('GET', 'https://api.github.com/repos/symfony/symfony-docs/contents');
        return $response->toArray();
    }

    public function getRstFiles()
    {
        $files = $this->getContents();
        foreach ($files as $file) {
            $length = strlen($file['name']);
            $extension = substr($file['name'], $length - 3);
            if($extension === 'rst') {
                $this->getContent($file);
            }
        }
    }

    public function getContent($file)
    {
        $response = $this->checkConnection()->request('GET', $file['url']);
        dump($response->toArray());
    }
}
